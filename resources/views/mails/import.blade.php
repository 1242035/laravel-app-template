<p>Total: {{ $total }}</p>
<p>Rejected: {{ $rejected }}</p>
<p>Inserted: {{ $inserted }}</p>
@if( isset( $arrFailed) && count( $arrFailed ) > 0 )
<p>Failed: </p>
<p>
    <table>
        @foreach( $arrFailed as $row)
            <tr>
                <td>{{ $row[1] ?? '' }}</td>
                <td>{{ $row[2] ?? '' }}</td>
                <td>{{ $row[3] ?? '' }}</td>
                <td>{{ $row[4] ?? '' }}</td>
                <td>{{ $row[5] ?? '' }}</td>
                <td>{{ $row[6] ?? '' }}</td>
            </tr>
        @endforeach
    </table>
</p>
@endif