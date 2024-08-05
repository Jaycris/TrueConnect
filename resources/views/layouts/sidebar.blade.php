<nav x-data="sidebar" class="sidebar fixed bottom-0 top-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
    <div class="h-full bg-white dark:bg-[#0e1726]">
        <div class="flex items-center justify-between px-4 py-3">
            <a href="{{ route('admin.dashboard') }}" class="main-logo flex shrink-0 items-center">
                <img class="align-middle h-12 mx-auto text-2xl ml-[5px] w-50 flex-none" src="{{ asset('assets/images/BMA-2024-Horizontal.png') }}" alt="image">
            </a>
            <a href="javascript:;" class="collapse-icon flex h-8 w-8 items-center rounded-full transition duration-300 hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10" @click="$store.app.toggleSidebar()">
                <svg class="m-auto h-5 w-5" width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        </div>
        <ul class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 overflow-y-auto overflow-x-hidden p-4 py-0 font-semibold">
            <li class="menu nav-item">
                <a class="nav-link group {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <div class="flex items-center">
                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" fill="currentColor"></path>
                            <path d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z" fill="currentColor"></path>
                        </svg>            
                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Dashboard</span>
                    </div>
                </a>
            </li>

            <h2 class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                <svg class="hidden h-5 w-4 flex-none" viewbox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span class="bmaColortext">Client and Sales</span>
            </h2>
            <li class="menu nav-item">
                <a class="nav-link group {{ request()->is('admin/users', 'admin/users/create', 'admin/users/*/edit') ? 'active' : '' }}" href="{{ route('admin.users') }}">                    
                    <div class="flex items-center">
                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" fill="currentColor"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5.25C12.4142 5.25 12.75 5.58579 12.75 6V6.31673C14.3804 6.60867 15.75 7.83361 15.75 9.5C15.75 9.91421 15.4142 10.25 15 10.25C14.5858 10.25 14.25 9.91421 14.25 9.5C14.25 8.82154 13.6859 8.10339 12.75 7.84748V11.3167C14.3804 11.6087 15.75 12.8336 15.75 14.5C15.75 16.1664 14.3804 17.3913 12.75 17.6833V18C12.75 18.4142 12.4142 18.75 12 18.75C11.5858 18.75 11.25 18.4142 11.25 18V17.6833C9.61957 17.3913 8.25 16.1664 8.25 14.5C8.25 14.0858 8.58579 13.75 9 13.75C9.41421 13.75 9.75 14.0858 9.75 14.5C9.75 15.1785 10.3141 15.8966 11.25 16.1525V12.6833C9.61957 12.3913 8.25 11.1664 8.25 9.5C8.25 7.83361 9.61957 6.60867 11.25 6.31673V6C11.25 5.58579 11.5858 5.25 12 5.25ZM11.25 7.84748C10.3141 8.10339 9.75 8.82154 9.75 9.5C9.75 10.1785 10.3141 10.8966 11.25 11.1525V7.84748ZM14.25 14.5C14.25 13.8215 13.6859 13.1034 12.75 12.8475V16.1525C13.6859 15.8966 14.25 15.1785 14.25 14.5Z" fill="currentColor"></path>
                        </svg>         
                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Sales</span>
                    </div>
                </a>
            </li>
            <li class="menu nav-item" x-data="{ activeDropdown: '{{ (request()->is('customers', 'admin/departments/create') || request()->is('admin/designations', 'admin/designations/create', 'admin/designations/*/edit')) ? 'settings' : null; }}' }">
                <button type="button" class="nav-link group" :class="{'active' : activeDropdown === 'settings'}" @click="activeDropdown = (activeDropdown === 'settings' ? null : 'settings')">
                    <div class="flex items-center">
                    <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="7" r="4" fill="currentColor"></circle>
                            <ellipse cx="12" cy="17" rx="7" ry="4" fill="currentColor"></ellipse>
                        </svg> 
                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Clients</span>
                    </div>      
                    <div class="rtl:rotate-180" :style="{ transform: activeDropdown === 'settings' ? 'rotate(90deg)' : 'rotate(0deg)' }">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>            
                </button>
                <ul x-cloak x-show="activeDropdown === 'settings'" x-collapse="" class="sub-menu text-gray-500">
                    <li>
                        <a class="{{ request()->is('customers') ? 'active' : '' }}" href="{{ route('customers.index') }}">Leads</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('admin/designations', 'admin/designations/create', 'admin/designations/*/edit') ? 'active' : '' }}" href="{{ route('admin.designations') }}">Clients</a>
                    </li>
                </ul>
            </li>

            <h2 class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                <svg class="hidden h-5 w-4 flex-none" viewbox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span class="bmaColortext">USERS AND SETTINGS</span>
            </h2>
            <li class="menu nav-item">
                <a class="nav-link group {{ request()->is('admin/users', 'admin/users/create', 'admin/users/*/edit') ? 'active' : '' }}" href="{{ route('admin.users') }}">                    
                    <div class="flex items-center">
                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle opacity="0.5" cx="15" cy="6" r="3" fill="currentColor"></circle>
                            <ellipse opacity="0.5" cx="16" cy="17" rx="5" ry="3" fill="currentColor"></ellipse>
                            <circle cx="9.00098" cy="6" r="4" fill="currentColor"></circle>
                            <ellipse cx="9.00098" cy="17.001" rx="7" ry="4" fill="currentColor"></ellipse>
                        </svg>        
                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Users</span>
                    </div>
                </a>
            </li>
            <li class="menu nav-item" x-data="{ activeDropdown: '{{ (request()->is('admin/departments', 'admin/departments/create') || request()->is('admin/designations', 'admin/designations/create', 'admin/designations/*/edit')) ? 'settings' : null; }}' }">
                <button type="button" class="nav-link group" :class="{'active' : activeDropdown === 'settings'}" @click="activeDropdown = (activeDropdown === 'settings' ? null : 'settings')">
                    <div class="flex items-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="3" fill="#616770" stroke="#616770" stroke-width="1.5"></circle>
                            <path opacity="0.5" d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z" fill="#7c8188" stroke="#7c8188" stroke-width="1.5"></path>
                        </svg>
                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Settings</span>
                    </div>      
                    <div class="rtl:rotate-180" :style="{ transform: activeDropdown === 'settings' ? 'rotate(90deg)' : 'rotate(0deg)' }">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>            
                </button>
                <ul x-cloak x-show="activeDropdown === 'settings'" x-collapse="" class="sub-menu text-gray-500">
                    <li>
                        <a class="{{ request()->is('admin/departments', 'admin/departments/create') ? 'active' : '' }}" href="{{ route('admin.department') }}">Department</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('admin/designations', 'admin/designations/create', 'admin/designations/*/edit') ? 'active' : '' }}" href="{{ route('admin.designations') }}">Designation</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>