<table class="table table-sm">
    <caption>Reservation List for PC # {{ $pc->name }}</caption>
    <thead>
        <tr>
            <th>#</th>
            <th>Start</th>
            <th>End</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pc->todaysReservations as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->reservationTime('h:i a') }}</td>
                <td>{{ $row->reservationTime()->addHours($row->duration_in_hours)->format('h:i a') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No reservations for this PC</td>
            </tr>
        @endforelse
    </tbody>
</table>
