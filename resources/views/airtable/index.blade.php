@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($allData as $data)
        <h2 class="mt-5">{{ $data['table'] }}</h2>
        <div class="row">
            @forelse($data['records'] as $record)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Record ID: {{ $record['id'] }}</h5>
                            @if(isset($record['fields']))
                                @foreach($record['fields'] as $fieldName => $fieldValue)
                                    <p class="card-text">
                                        <strong>{{ $fieldName }}:</strong>
                                        {{ is_array($fieldValue) ? implode(', ', $fieldValue) : $fieldValue }}
                                    </p>
                                @endforeach
                            @else
                                <p class="text-muted">No fields available for this record.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted ms-3">No records found for this table.</p>
            @endforelse
        </div>
    @endforeach
</div>
@endsection
