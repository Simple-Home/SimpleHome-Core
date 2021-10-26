 @if (!empty($usersLocators))
     <div class="avatars d-flex">
         @foreach ($usersLocators as $userLocator)
             <div title="{{ $userLocator->name }}" class="avatar">
                 <img src="{{ $userLocator->getGavatarUrl() }}" alt="{{ $userLocator->name }}">
             </div>
         @endforeach
     </div>
 @endif
