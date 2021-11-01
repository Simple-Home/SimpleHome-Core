<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">{{ __('simplehome.oauth.clients') }}
        <button class="btn btn-primary"><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Client ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Secret</th>
                    <th scope="col text-end"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authorizedClients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->name }}</td>
                        <td><code class="text-break">{{ $client->secret }}</code></td>
                        <td class="col-auto text-end fit">
                            <div class="btn btn-info p-1">
                                <button data-url="{{ route('system.locations.ajax.edit', ['location_id' => 0]) }}"
                                    class="location-edit btn btn-primary" title="{{ __('simplehome.edit') }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <a href="{{ route('system.locations.remove', ['location_id' => 0]) }}"
                                    class="btn btn-danger" title="{{ __('simplehome.delete') }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        {{ __('simplehome.oauth.authorized.apps') }}

    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Scope</th>
                    <th scope="col">expire</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authenticatedApps as $token)
                    <tr>
                        <td>{{ $token->client->name }}</td>
                        <td>{{ $token->scope }}</td>
                        <td>{{ $token->expires_at }}</td>
                        <td class="col-auto text-end fit">
                            <div class="btn btn-info p-1">
                                @if (!$token->revoked)
                                    <button
                                        data-url="{{ route('system.locations.ajax.edit', ['location_id' => 0]) }}"
                                        class="location-edit btn btn-primary" title="{{ __('simplehome.edit') }}">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                @endif
                                <a href="{{ route('system.locations.remove', ['location_id' => 0]) }}"
                                    class="btn btn-danger" title="{{ __('simplehome.delete') }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        {{ __('simplehome.oauth.personal.tokens') }}
        <button class="btn btn-primary" data-url="{{ route('system.developments.ajax.new') }}"
            title="{{ __('simplehome.create') }}">><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">{{ __('simplehome.name') }}</th>
                    <th scope="col" class="d-none d-md-table-cell">{{ __('simplehome.scope') }}</th>
                    <th scope="col" class="col-auto text-end fit">{{ __('simplehome.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($personalTokens as $personalAccessToken)
                    <tr>
                        <td>{{ $personalAccessToken->name }}</td>
                        <td scope="col" class="d-none d-md-table-cell">{{ $personalAccessToken->scope }}</td>
                        <td class="col-auto text-end fit">
                            <div class="btn btn-info p-1">
                                @if (!$personalAccessToken->revoked)
                                    <button
                                        data-url="{{ route('system.locations.ajax.edit', ['location_id' => 0]) }}"
                                        class="location-edit btn btn-primary" title="{{ __('simplehome.edit') }}">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                @endif
                                <a href="{{ route('system.locations.remove', ['location_id' => 0]) }}"
                                    class="btn btn-danger" title="{{ __('simplehome.delete') }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
