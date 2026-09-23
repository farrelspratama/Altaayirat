@if ($errors->any())
    <div style="color: #b71c1c; background-color: #ffebee; border: 1px solid #ef9a9a; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif