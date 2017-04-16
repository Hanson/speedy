@if (!Auth::guest())
<div id="sidebar" class="sidebar">
    <div class="sidebar-brand">
        <a href="{{ url('admin') }}">{{ config('app.name') }}</a>
    </div>
    <div class="sidebar-body">
        <ul>
            <template v-for="(menu, key) in menus">
                <li class="first-menu-li">
                    <a v-bind:class="[isCurrentUrl(menu.url) ? 'active' : '', 'first-menu']" v-on:click="toggleMenu(key)" v-bind:id="'menu-' + key" v-bind:href="menu.url ? menu.url : 'javascript:;'">@{{ menu.display }}
                        <span v-if="menu.sub" class="glyphicon glyphicon-chevron-down" v-bind:class="{ 'menu-expand-indicator' : active == key }"></span>
                    </a>
                    <ul v-if="menu.sub" v-bind:id="'sub-menu-' + key" class="sub-menu" v-bind:style="{display: active == key ? 'block' : 'none'}">
                        <template v-for="sub in menu.sub">
                            <li class="second-menu-li"><a v-bind:class="[isCurrentUrl(sub.url, key) ? 'active' : '', 'first-menu']" v-bind:href="sub.url" v-bind:target="sub.target ? sub.target : ''">@{{ sub.display }}</a></li>
                        </template>
                    </ul>
                </li>
            </template>
        </ul>
    </div>
</div>
@endif
