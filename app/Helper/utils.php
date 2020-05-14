<?php
/**
 * @param object $exception
 * @return array
 */
function formatException($exception)
{
    return [
        'exception' => get_class($exception),
        'file'      => $exception->getFile(),
        'line'      => $exception->getLine(),
        'message'   => $exception->getMessage(),
    ];
}

function formatPhone($phone)
{
    if (preg_match('/^(\d{3})(\d{3})(\d{4})$/', $phone, $matches)) {
        $result = '(' . $matches[1] . ')-' . $matches[2] . '-' . $matches[3];
        return $result;
    }

    return $phone;
}

function uploadFile($file, $type = "images", $category = 'product', $disk = "default")
{
    $fileContent = file_get_contents($file->getRealPath());
    $extension = $file->getClientOriginalExtension();
    $fileName = uniqid("{$category}_") . ".$extension";
    $path = "/$type/$category/$fileName";
    $disk !== "default" ? storage()->disk($disk)->put($path, $fileContent) : storage()->put($path, $fileContent);
    if ($type == 'images') {
        // resize image
        $resizePath = "/$type/$category/resize/$fileName";
        $resizedImage = Image::make($fileContent)->resize(null, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->encode($extension);

        $disk !== "default" ? storage()->disk($disk)->put($resizePath, (string)$resizedImage) : storage()->put($resizePath, (string)$resizedImage);
    }

    return $path;
}

function uploadFileLocal($file, $category = 'emails')
{
    $fileContent = file_get_contents($file->getRealPath());
    $fileName = $file->getClientOriginalName();
    $path = "$category/" . uniqid() . '/' . $fileName;
    storage()->disk('local')->put($path, $fileContent);
    return $path;
}

function getExtensionFromMime($mine)
{
    switch ($mine) {
        case 'image/jpeg':
            $extension = 'jpg';
            break;

        case 'image/png':
            $extension = 'png';
            break;

        case 'image/gif':
            $extension = 'gif';
            break;
        default:
            $extension = '';
            break;
    }
    return $extension;
}

function getUrlFilePublic($path)
{
    return $path ? storage()->disk('public')->url($path) : "";
}


function getUrlFileS3($path, $is_resize = false)
{
    return $path ? ($is_resize ? storage()->disk('s3')->url(getImageResizePath($path)) : storage()->disk('s3')->url($path)) : "";
}

function getImageResizePath($path)
{
    $pathToArray = explode("/", $path);
    array_splice($pathToArray, 3, 0, "resize");
    return implode("/", $pathToArray);
}

function getUrlFile($path, $resize = false)
{
    return $resize ? storage()->url($path) : storage()->url(getImageResizePath($path));
}

function tagImgAvatar($path)
{
    if (storage()->disk('public')->exists(getImageResizePath($path))) {
        return '<img src="' . storage()->disk('public')->url(getImageResizePath($path)) . '" style="width: 50px;"/>';
    } else {
        return '<img src="' . storage()->disk('public')->url($path) . '" style="width: 50px;"/>';
    }
    return "";
}

/**
 * @param $mixed $array
 *
 * @return array
 */
function arrayKeys($array)
{
    if (!is_array($array)) {
        return [];
    }

    return array_keys($array);
}

/**
 * @param $mixed $array1
 * @param $mixed $array2
 *
 * @return array
 */
function arrayMerge($array1, $array2)
{
    if (!is_array($array1)) {
        $array1 = [];
    }

    if (!is_array($array2)) {
        $array2 = [];
    }

    return array_merge($array1, $array2);
}

function sessionSearch($key, \Illuminate\Http\Request &$request)
{
    $params = $request->session()->get($key);
    if (is_array($params)) {
        $request->request->add(array_merge($params, $request->all()));
    }
    $request->session()->put($key, $request->all());
    return $request;
}

function dateNow()
{
    return date('Y/m/d', time());
}

function getDateFromTimestamp($timestamp)
{
    return date('Y/m/d', $timestamp);
}

function formatNumber($number)
{
    if ($number - (int)$number > 0.001) {
        $number = number_format(round($number, 2),2);
    } else {
        $number = number_format($number);
    }
    return $number;
}

function formatMoney($number)
{
    if ($number - (int)$number > 0.001) {
        $number = number_format(round($number, 2),2);
    } else {
        $number = number_format($number);
    }

    $number = '¥' . $number;
    return $number;
}
