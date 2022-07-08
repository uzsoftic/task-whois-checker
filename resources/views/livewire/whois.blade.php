<div class="bg-light p-5 rounded">

    <h1>Check Domain Availability</h1>
    <p class="lead">Type domain name. (etc. google.com)</p>

    <form class="row g-3">
        <div class="col-9">
            <label for="inputPassword2" class="visually-hidden">Password</label>
            <input type="text" class="form-control" wire:model="search" id="search" name="search" placeholder="google.com" value="{{ $search }}">
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-primary mb-3 w-100">Check</button>
        </div>
    </form>

    <ul>
        @if(isset($domain))

            @if($domain->status == true)
                <li><b class="text-success">This domain exists! [{{ $search }}]</b></li>
                <li><b>Message:</b> {{ $domain->message }}</li>
                <li><b>Domain Name:</b> {{ $domain->data->domainName }}</li>
                <li><b>DNS:</b> ({{ implode(", ", $domain->data->nameServers) }})</li>
                <li><b>Registrator:</b> {{ $domain->data->registrar }}</li>
                <li><b>Whois Server:</b> {{ $domain->data->whoisServer }}</li>
                <li><b>Owner:</b> {{ $domain->data->owner ?? "Hidden" }}</li>

                <li><b>Created:</b> {{ date("d.m.Y", $domain->data->creationDate) }}</li>
                <li><b>Expire:</b> {{ date("d.m.Y", $domain->data->expirationDate) }}</li>
            @else
                <li><b class="text-danger">This domain does not exist! [{{ $search }}]</b></li>
            @endif

        @else
            <li>Domain not found! Please enter domain name...</li>
        @endif
    </ul>

    <div class="pt-5">
        <h2>Debug Response Panel:</h2>
        @dump($domain)
    </div>



</div>
