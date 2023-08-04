				<!--aside open-->
				<aside class="app-sidebar">
					<div class="app-sidebar__logo">
						<a class="header-brand" href="{{url('index')}}">
							<img src="{{asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Azea logo">
							<img src="{{asset('assets/images/brand/logo1.png')}}" class="header-brand-img dark-logo" alt="Azea logo">
							<img src="{{asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Azea logo">
							<img src="{{asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Azea logo">
						</a>
					</div>
					<ul class="side-menu app-sidebar3">
						@foreach(config('menu.sidebar') as $sidebar)

						<li class="side-item side-item-category">{{ $sidebar['category'] }}</li>
						
						<li class="slide">
							<a class="side-menu__item" data-bs-toggle="slide" href="{{ (array_key_exists('childs', $sidebar)) ? 'javascript::void(0);' : route($sidebar['route']) }}">
								<i class="{{ $sidebar['icon'] }} pe-3 ps-2"></i>
								<span class="side-menu__label">{{ $sidebar['label'] }}</span>
								{!! (array_key_exists('childs', $sidebar)) ? '<i class="angle fe fe-chevron-right"></i>' :'' !!}
							</a>
							@if(array_key_exists('childs', $sidebar)))
							<ul class="slide-menu">
								@foreach($sidebar['childs'] as $child)
								<li><a href="{{ route($child['route']) }}" class="slide-item">{{ $child['label'] }}</a></li>
								@endforeach
							</ul>
							@endif
						</li>
						
						@endforeach
						<li class="side-item side-item-category">Components</li>
						<li class="slide">
							<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
								<svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M12 22c4.879 0 9-4.121 9-9s-4.121-9-9-9-9 4.121-9 9 4.121 9 9 9zm0-16c3.794 0 7 3.206 7 7s-3.206 7-7 7-7-3.206-7-7 3.206-7 7-7zm5.284-2.293 1.412-1.416 3.01 3-1.413 1.417zM5.282 2.294 6.7 3.706l-2.99 3-1.417-1.413z"/><path d="M11 9h2v5h-2zm0 6h2v2h-2z"/></svg>
							<span class="side-menu__label">Utilities</span><i class="angle fe fe-chevron-right"></i></a>
							<ul class="slide-menu">
								<li><a href="{{url('element-border')}}" class="slide-item"> Border</a></li>
								<li><a href="{{url('element-colors')}}" class="slide-item"> Colors</a></li>
								<li><a href="{{url('element-display')}}" class="slide-item"> Display</a></li>
								<li><a href="{{url('element-flex')}}" class="slide-item"> Flex Items</a></li>
								<li><a href="{{url('element-height')}}" class="slide-item"> Height</a></li>
								<li><a href="{{url('element-margin')}}" class="slide-item"> Margin</a></li>
								<li><a href="{{url('element-padding')}}" class="slide-item"> Padding</a></li>
								<li><a href="{{url('element-typography')}}" class="slide-item"> Typhography</a></li>
								<li><a href="{{url('element-width')}}" class="slide-item"> Width</a></li>
							</ul>
						</li>
					</ul>
				</aside>
				<!--aside closed-->