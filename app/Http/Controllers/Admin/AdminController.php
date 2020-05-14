<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Models\TransactionSupplier;
use App\Models\User;
use App\Models\Order;
use App\Models\Supplier;
use App\Repositories\TransactionSupplierRepository;
use App\Repositories\UserRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderRepository;
use App\Repositories\SupplierRepository;
use App\Models\Transaction;
use App\Repositories\InvoiceRepository;
use App\Repositories\TransactionRepository;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Exports\BalanceExport;
use Excel;

use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function accounts(Request $request)
    {
        $search = $request->input('search');
        $states = User::STATES;

        $currentFromAjax = $request->get('currentFromAjax');
        $current = $request->get('current') ?? 'customer';

        if ($current == 'customer') {
            $customers = UserRepository::lastOrder($search);
            $suppliers = SupplierRepository::lastOrder();
            $customersRaw = CustomerRepository::lastOrder();
        }
        else if ($current == 'customer-raw') {
            $customers = UserRepository::lastOrder();
            $suppliers = SupplierRepository::lastOrder();
            $customersRaw = CustomerRepository::lastOrder($search);

        } else {
            $customers = UserRepository::lastOrder();
            $suppliers = SupplierRepository::lastOrder($search);
            $customersRaw = CustomerRepository::lastOrder();
        }

        if ($request->ajax()) {
            if ($currentFromAjax == 'supplier') {
                return view('admin.admin.includes.accounts.supplier-data', ['suppliers' => $suppliers]);
            }
            else if ($currentFromAjax == 'customer-raw') {
                return view('admin.admin.includes.accounts.customer-raw-data', ['customers' => $customersRaw]);
            }
            return view('admin.admin.includes.accounts.customer-data', ['customers' => $customers]);
        }

        return view('admin.admin.accounts', [
            'title'        => __('元帳'),
            'orders'       => [],
            'states'       => $states,
            'customers'    => $customers,
            'suppliers'    => $suppliers,
            'customersRaw' => $customersRaw,
            'current'      => $current,
        ]);
    }

    public function searchCustomer()
    {
        $response = ['success' => 1, 'data' => null];
        $email = request()->email;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $customer = CustomerRepository::getCustomerByEmail( $email );
            if( isset( $customer->id ) ) {
                $response['data'] = new \App\Http\Resources\CustomerResource( $customer );
            }
        }
        return response()->json( $response );
    }

    public function balance(Request $request)
    {
        $userCash = UserRepository::getUserByBalanceType(User::TYPE_CASH);
        $userCashId = [];
        foreach ($userCash as $user) {
            array_push($userCashId, $user->id);
        }
        $search = $request->input('search');
        $orderCash = OrderRepository::getOrderByWhere($search, $userCashId);
        $userShortTerm = UserRepository::getUserByBalanceType(User::TYPE_SHORT_TERM);
        $userShortTermId = [];
        foreach ($userShortTerm as $user) {
            array_push($userShortTermId, $user->id);
        }
        $orderShortTerm = OrderRepository::getOrderByWhere($search, $userShortTermId);

        $userReceivable = UserRepository::getUserByBalanceType(User::TYPE_RECEIVABLE);
        $userReceivableId = [];
        foreach ($userReceivable as $user) {
            array_push($userReceivableId, $user->id);
        }
        $orderReceivable = OrderRepository::getOrderByWhere($search, $userReceivableId);

        if ($request->ajax()) {
            $url = $request->fullUrl();
            if (strpos($url, 'short-term')) {
                return view('admin.admin.balance.short-term', ['orderShortTerm' => $orderShortTerm])->render();
            } elseif (strpos($url, 'cash')) {
                return view('admin.admin.balance.cash', ['orderCash' => $orderCash])->render();
            }

            return view('admin.admin.balance.receivable', ['orderReceivable' => $orderReceivable])->render();
        }
        return view('admin.admin.balance', [
            'title'           => __('残高一覧'),
            'orders'          => [],
            'orderCash'       => $orderCash,
            'orderShortTerm'  => $orderShortTerm,
            'orderReceivable' => $orderReceivable,
        ]);
    }

    public function exportExcel(Request $request, $type)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', '日付け')
            ->setCellValue('B1', '店舗名')
            ->setCellValue('C1', '品名')
            ->setCellValue('D1', '数量')
            ->setCellValue('E1', '単位')
            ->setCellValue('F1', '金額')
            ->setCellValue('G1', '');

        $spreadsheet->getActiveSheet()->getStyle('A1')
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('B1')
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('C1')
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('D1')
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('E1')
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('F1')
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('G1')
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $users = UserRepository::getUserByBalanceType($type);
        $userId = [];
        foreach ($users as $user) {
            array_push($userId, $user->id);
        }
        $search = $request->input('search');
        $orders = OrderRepository::getOrderByWhere($search, $userId);
        $count = 2;
        $count1 = 2;
        foreach ($orders as $key => $order) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $count, date('Y年m月d日', strtotime($order->order_date)))
                ->setCellValue('B' . $count, $order->user->name);

            $spreadsheet->getActiveSheet()->getStyle('A' . $count)
                ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('B' . $count)
                ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            foreach ($order->orderItems as $key1 => $item) {

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('C' . $count1, $item->product->name)
                    ->setCellValue('D' . $count1, $item->quantity)
                    ->setCellValue('E' . $count1, 'Kg')
                    ->setCellValue('F' . $count1, formatMoney($item->price * $item->quantity * (1 + $item->tax)));

                $spreadsheet->getActiveSheet()->getStyle('A' . $count1)
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle('B' . $count1)
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle('C' . $count1)
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle('D' . $count1)
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle('E' . $count1)
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle('F' . $count1)
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle('G' . $count1)
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $count1++;
            }
            if ($key1 == 0) {
                $count2 = $count;
            } else {
                $count2 = $count1 - 1;
            }
            $spreadsheet->getActiveSheet()->mergeCells('A' . $count . ':' . 'A' . $count2);
            $spreadsheet->getActiveSheet()->mergeCells('B' . $count . ':' . 'B' . $count2);
            $spreadsheet->getActiveSheet()->mergeCells('G' . $count . ':' . 'G' . $count2);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('G' . $count, ($order->status == Order::STATUS_CONFIRM) ? '確認済み' : '未確認');

            $spreadsheet->getActiveSheet()->getStyle('G' . $count)
                ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $conditional1 = new Conditional();
            $conditional1->setConditionType(Conditional::CONDITION_CONTAINSTEXT)
                ->setOperatorType(Conditional::OPERATOR_NOTCONTAINS)
                ->setText('確認済み');
            $conditional1->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_RED);

            $conditional2 = new Conditional();
            $conditional2->setConditionType(Conditional::CONDITION_CONTAINSTEXT)
                ->setOperatorType(Conditional::OPERATOR_NOTCONTAINS)
                ->setText('未確認');
            $conditional2->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_GREEN);


            $conditionalStyles = $spreadsheet->getActiveSheet()->getStyle('G' . $count)->getConditionalStyles();
            $conditionalStyles[] = $conditional1;
            $conditionalStyles[] = $conditional2;
            $spreadsheet->getActiveSheet()->getStyle('G' . $count)->setConditionalStyles($conditionalStyles);
            $count = $count1;
        }
        $spreadsheet->getActiveSheet()->getStyle('A1:G' . $count)
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
        $isIe = false;
        if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0; rv:11.0') !== false)) {
            $isIe = true;
        }
        if ($type == User::TYPE_CASH) {
            $fileName = '現金.xlsx';
            if ($isIe) {
                $fileName = urlencode($fileName);
            }
            header('Content-Disposition: attachment;filename=' . $fileName);
        }
        if ($type == User::TYPE_SHORT_TERM) {
            $fileName = '短期売掛.xlsx';
            if ($isIe) {
                $fileName = urlencode($fileName);
            }
            header('Content-Disposition: attachment;filename=' . $fileName);
        }
        if ($type == User::TYPE_RECEIVABLE) {
            $fileName = '売掛.xlsx';
            if ($isIe) {
                $fileName = urlencode($fileName);
            }
            header('Content-Disposition: attachment;filename=' . $fileName);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    /**
     * ScreenID: AD014.1 AD014.2
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailMoney(Request $request)
    {
        $suppliers = SupplierRepository::getAllSuppliers();
        $supplierName = [];
        foreach ($suppliers as $key => &$supplier) {
            $supplierName[] = [
                'id'   => $supplier->id,
                'text' => "$supplier->name($supplier->email)",
            ];
        }
        $users = UserRepository::getAll();
        $storeName = [];
        foreach ($users as $key => &$user) {
            $storeName[] = [
                'id'   => $user->id,
                'text' => "$user->name($user->email)",
            ];
        }
        $transactions = TransactionRepository::getList($request->input('search'), $request->input('date'), $request->input('filter'));
        $transactionSupplier = TransactionSupplierRepository::getList($request->input('search'), $request->input('date'), $request->input('filter'));

        if ($request->ajax()) {
            return TransactionRepository::apiDetailMoney($request, $transactions, $transactionSupplier);
        }
        return view('admin.admin.detail-money', [
            'title'                => __('入出金明細'),
            'orders'               => [],
            'store_name'           => $storeName,
            'supplier_name'        => $supplierName,
            'transactions'         => $transactions,
            'transaction_supplier' => $transactionSupplier,
        ]);
    }

    /**
     * ScreenID: AD015.1 AD015.2
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmSale(Request $request)
    {
        $search = request('search');
        $currentTab = request('current_tab');

        if (!$currentTab) {
            $currentTab = 'invoice';
        }

        if ($request->ajax()) {
            if ($currentTab == 'invoice') {
                $invoices = InvoiceRepository::getInvoiceData($search);
                return view('admin.admin.includes.confirm-sale.invoice-data', [
                    'invoices' => $invoices
                ])->render();
            } else {
                $supplierTransactions = TransactionSupplierRepository::getSupplierTransactionData($search);
                return view('admin.admin.includes.confirm-sale.supplier-transaction-data', [
                    'supplierTransactions' => $supplierTransactions
                ])->render();
            }
        }

        if ($currentTab == 'invoice') {
            $invoices = InvoiceRepository::getInvoiceData($search);
            $supplierTransactions = TransactionSupplierRepository::getSupplierTransactionData();
        } else {
            $invoices = InvoiceRepository::getInvoiceData();
            $supplierTransactions = TransactionSupplierRepository::getSupplierTransactionData($search);
        }

        return view('admin.admin.confirm-sale', [
            'title'                => __('売上・仕入照合'),
            'invoices'             => $invoices,
            'supplierTransactions' => $supplierTransactions,
        ]);
    }

    /**
     * [storeAccount Create customer from customer screen]
     * @param StoreUserRequest $request [Illuminate\Foundation\Http\FormRequest]
     * @return [Illuminate\Http\Route]                    [redirect to accounts index with message]
     */
    public function storeAccount(StoreUserRequest $request)
    {
        $data = $request->only(
            'name',
            'email',
            'phone_number',
            'pref_id',
            'addr01',
            'addr02',
            'balance_type',
            'password'
        );
        $message = UserRepository::store($data);

        return back()->with($message['status'], $message['content']);
    }

    public function updateAccount(Request $request, $id, $type)
    {
        $data = $this->validateAndGenerateData($request, $type);
        if ($type == 'customer') {
            $message = UserRepository::update($data, $id);
        } 
        else {
            $message = SupplierRepository::update($data, $id);
        }

        return back()->with($message['status'], $message['content']);
    }

    /**
     * [getUser Get user by type]
     * @param  [int] $id   [id of user]
     * @param  [string] $type [customer or supplier]
     * @return [http]       [http response]
     */
    public function getUser($id, $type)
    {
        if ($type == 'customer') {
            $user = User::findOrFail($id);
            return response()->json($user);
        }

        $user = Supplier::findOrFail($id);
        return response()->json($user);
    }

    /**
     * [storeSupplier Store supplier from admin]
     * @param StoreSupplierRequest $request [Validate class]
     * @return [Illuminate\Http\Request]                        [redirect to index]
     */
    public function storeSupplier(StoreSupplierRequest $request)
    {
        $data    = $this->validateAndGenerateSupplierData($request);
        $message = SupplierRepository::store($data);

        return back()->with($message['status'], $message['content']);
    }


    private function validateAndGenerateData(Request $request, string $type)
    {
        $data = [];
        if ($type == 'customer') {
            $request->validate([
                'name'         => 'required|max:100',
                'email'        => 'required|email',
                'phone_number' => 'required',
                'pref_id'      => 'required',
                'addr01'       => 'required',
                'addr02'       => 'required',
                'balance_type' => 'required'
            ]);
            $data = $request->only(
                'name',
                'email',
                'phone_number',
                'pref_id',
                'addr01',
                'addr02',
                'balance_type',
                'password'
            );
        } else {
            $data = $this->validateAndGenerateSupplierData($request);
        }
        return $data;
    }

    private function validateAndGenerateSupplierData(Request $request)
    {
        $data = [];
        
        $request->validate([
            'name'         => 'required|max:100',
            'email'        => 'required|email',
            'phone_number' => 'required',
            'pref_id'      => 'required',
            'addr01'       => 'required',
            'addr02'       => 'required',
        ]);

        $data = $request->only(
            'name',
            'email',
            'phone_number',
            'pref_id',
            'addr01',
            'addr02',
            'code',
            'sort_name',
            'deparment_name',
            'office_name',
            'office_header',
            'title',
            'fax',
            'home_page',
            'office_header_2',
            'no_name_1',
            'transaction_type',
            'price_unit',
            'hang_rate',
            'closing_group',
            'no_name_2',
            'fractional_processing',
            'tax_fraction_processing',
            'tax_transfer',
            'accounts_payable',
            'payment_method_1',
            'no_name_3',
            'no_name_4',
            'payment_method_2',
            'no_name_5',
            'no_name_6',
            'payment_base_amount',
            'divide',
            'payment_cycle',
            'payment_date',
            'site',
            'house_bank_number',
            'house_bank_name_transfer',
            'house_bank_name_phonetic',
            'transaction_branch_number',
            'bank_head_office_name',
            'branch_name',
            'account_relationship',
            'deposit_type',
            'account_number',
            'account_holder',
            'account_name_reading',
            'customer_code_1',
            'customer_code_2',
            'fee_burden',
            'transfer_method',
            'category_1',
            'no_name_7',
            'category_2',
            'no_name_8',
            'category_3',
            'no_name_9',
            'category_4',
            'no_name_10',
            'category_5',
            'no_name_11',
            'memmo',
            'reference_indication',
            //'updated_time',
            'postal_code',
            'name_kana'
        );
        if( isset( $request->updated_time ) && !empty( $request->updated_time ) )
        {
            try{
                $updatedTime = Carbon::createFromFormat('Y年m月d日', $request->updated_time)->format('Y-m-d h:m:s');
                $data['updated_time'] = $updatedTime;
            }catch(\Exception $e) {
                try{
                    $updatedTime = Carbon::createFromFormat('Y-m-d', $request->updated_time)->format('Y-m-d h:m:s');
                    $data['updated_time'] = $updatedTime;
                }catch(\Exception $e){
                    try{
                        $updatedTime = Carbon::createFromFormat('Y/m/d', $request->updated_time)->format('Y-m-d h:m:s');
                        $data['updated_time'] = $updatedTime;
                    }catch(\Exception $e){
                        try{
                            $updatedTime = Carbon::createFromFormat('d/m/Y', $request->updated_time)->format('Y-m-d h:m:s');
                            $data['updated_time'] = $updatedTime;
                        }catch(\Exception $e){
    
                        }
                    }
                }
            }
        }
        return $data;
    }

}
