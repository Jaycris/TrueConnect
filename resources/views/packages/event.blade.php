@extends('layouts.master')
@section('content')

<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <span>Events</span>
        </li>
    </ul>
    <div class="panel mt-6">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold dark:text-white-light">Events</h5>
            <a href="{{ route('event.create') }}" class="btn btn-primary">Add Event</a>
        </div>
        @if(session('success'))
            <p id="success-message" class="text-success 500 italic">{{ session('success') }}</p>
        @endif
        <div class="mb-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkAll form-checkbox" />Select All</th>
                            <th>#</th>
                            <th>Event</th>
                            <th class="text-right flex">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($event as $events)
                        <tr>
                            <td><input type="checkbox" class="form-checkbox" /></td>
                            <td>{{ $events->id }}</td>
                            <td>{{ $events->event_name }}</td>
                            <td class="text-center">
                                <ul class="flex items-center gap-2">
                                    <li>
                                        <a href="{{ route('event.view', $events->id) }}" x-tooltip="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                <path fill-rule="evenodd" d="M2.538 10c1.905-3.507 5.366-6 7.462-6s5.557 2.493 7.462 6c-.905 3.507-3.773 6-7.462 6s-6.557-2.493-7.462-6zm7.462 4c-2.154 0-4.066-1.743-5.342-4 .73-1.38 2.147-3 5.342-3s4.612 1.62 5.342 3c-1.276 2.257-3.188 4-5.342 4zm0-6a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('event.edit', $events->id) }}" x-tooltip="Edit">
                                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-success">
                                                <path d="M15.2869 3.15178L14.3601 4.07866L5.83882 12.5999L5.83881 12.5999C5.26166 13.1771 4.97308 13.4656 4.7249 13.7838C4.43213 14.1592 4.18114 14.5653 3.97634 14.995C3.80273 15.3593 3.67368 15.7465 3.41556 16.5208L2.32181 19.8021L2.05445 20.6042C1.92743 20.9852 2.0266 21.4053 2.31063 21.6894C2.59466 21.9734 3.01478 22.0726 3.39584 21.9456L4.19792 21.6782L7.47918 20.5844L7.47919 20.5844C8.25353 20.3263 8.6407 20.1973 9.00498 20.0237C9.43469 19.8189 9.84082 19.5679 10.2162 19.2751C10.5344 19.0269 10.8229 18.7383 11.4001 18.1612L11.4001 18.1612L19.9213 9.63993L20.8482 8.71306C22.3839 7.17735 22.3839 4.68748 20.8482 3.15178C19.3125 1.61607 16.8226 1.61607 15.2869 3.15178Z" stroke="currentColor" stroke-width="1.5"></path>
                                                <path opacity="0.5" d="M14.36 4.07812C14.36 4.07812 14.4759 6.04774 16.2138 7.78564C17.9517 9.52354 19.9213 9.6394 19.9213 9.6394M4.19789 21.6777L2.32178 19.8015" stroke="currentColor" stroke-width="1.5"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                    <button onclick="document.getElementById('usersModal').style.display='block'" title="Delete" style="background: none; border: none; padding: 0; margin: 0;">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem; color: #dc3545;">
        <path d="M20.5 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
        <path d="M18.833 8.5L18.373 15.399C18.196 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.048 21 12.387 21H11.613C8.953 21 7.622 21 6.757 20.1907C5.892 19.3815 5.804 18.054 5.627 15.399L5.167 8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
        <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
        <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
        <path opacity="0.5" d="M6.5 6C6.556 6 6.584 6 6.609 5.999C7.433 5.978 8.159 5.455 8.439 4.68C8.448 4.656 8.457 4.63 8.474 4.577L8.571 4.286C8.654 4.037 8.696 3.913 8.751 3.807C8.97 3.386 9.376 3.094 9.845 3.019C9.962 3 10.093 3 10.355 3H13.645C13.907 3 14.038 3 14.155 3.019C14.624 3.094 15.03 3.386 15.249 3.807C15.304 3.913 15.346 4.037 15.429 4.286L15.526 4.577C15.543 4.63 15.552 4.657 15.561 4.68C15.841 5.455 16.567 5.978 17.391 5.999C17.416 6 17.444 6 17.5 6" stroke="currentColor" stroke-width="1.5"></path>
    </svg>
</button>
                                    
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Modal -->
                <div id="usersModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); z-index: 9999; overflow-y: auto;">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 1rem;" onclick="document.getElementById('usersModal').style.display='none'">
        <div style="background: white; border-radius: 0.5rem; overflow: hidden; max-width: 500px; width: 100%;" onclick="event.stopPropagation()">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border-bottom: 1px solid #ddd;">
                <h5 style="margin: 0; font-size: 1.25rem; font-weight: bold;">Confirm Delete</h5>
                <button onclick="document.getElementById('usersModal').style.display='none'" style="background: none; border: none; color: #888; cursor: pointer;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div style="padding: 1rem;">
                <p>Are you sure you want to delete this item?</p>
                <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                    <button onclick="document.getElementById('usersModal').style.display='none'" style="margin-right: 0.5rem; padding: 0.5rem 1rem; background: none; border: 1px solid #ddd; border-radius: 0.25rem; cursor: pointer;">Cancel</button>
                    <button onclick="alert('Item Deleted!'); document.getElementById('usersModal').style.display='none'" style="padding: 0.5rem 1rem; background: #dc3545; color: white; border: none; border-radius: 0.25rem; cursor: pointer;">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
                
            </div>
        </div>
    </div>
</div>
@endsection