@php
use Carbon\Carbon;
@endphp

<div class="message-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="massage-notification">
                    <div class="d-flex align-items-center">
                        <h5>Messages</h5>
                        <span class="badge">2</span>
                    </div>
                    <a href="#" class="cmn-btn edit-btn" id="new-message" data-bs-toggle="modal" data-bs-target="#msgBox">
                        <svg class="me-1" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4974 18.3327C15.0807 18.3327 18.8307 14.5827 18.8307 9.99935C18.8307 5.41602 15.0807 1.66602 10.4974 1.66602C5.91406 1.66602 2.16406 5.41602 2.16406 9.99935C2.16406 14.5827 5.91406 18.3327 10.4974 18.3327Z" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.16406 10H13.8307" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10.5 13.3327V6.66602" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> Add Message
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="chat-area">
                    <div class="chat-lists">
                        <div class="chat-header">

                            <div class="chat-functions d-none">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.07 5.92969L4 11.9997L10.07 18.0697" stroke="#0F172A" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M21.0019 12H4.17188" stroke="#0F172A" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <h6 class="check-counter"></h6>
                                </div>
                                <div class="ms-auto d-flex gap-3">
                                    <span class="multi-read">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.5019 16.3299C10.1119 16.3299 8.17188 14.3899 8.17188 11.9999C8.17188 9.60992 10.1119 7.66992 12.5019 7.66992C14.8919 7.66992 16.8319 9.60992 16.8319 11.9999C16.8319 14.3899 14.8919 16.3299 12.5019 16.3299ZM12.5019 9.16992C10.9419 9.16992 9.67188 10.4399 9.67188 11.9999C9.67188 13.5599 10.9419 14.8299 12.5019 14.8299C14.0619 14.8299 15.3319 13.5599 15.3319 11.9999C15.3319 10.4399 14.0619 9.16992 12.5019 9.16992Z" fill="#64748B" />
                                            <path d="M12.4981 21.0205C8.73812 21.0205 5.18813 18.8205 2.74812 15.0005C1.68813 13.3505 1.68813 10.6605 2.74812 9.00047C5.19812 5.18047 8.74813 2.98047 12.4981 2.98047C16.2481 2.98047 19.7981 5.18047 22.2381 9.00047C23.2981 10.6505 23.2981 13.3405 22.2381 15.0005C19.7981 18.8205 16.2481 21.0205 12.4981 21.0205ZM12.4981 4.48047C9.26813 4.48047 6.17813 6.42047 4.01813 9.81047C3.26813 10.9805 3.26813 13.0205 4.01813 14.1905C6.17813 17.5805 9.26813 19.5205 12.4981 19.5205C15.7281 19.5205 18.8181 17.5805 20.9781 14.1905C21.7281 13.0205 21.7281 10.9805 20.9781 9.81047C18.8181 6.42047 15.7281 4.48047 12.4981 4.48047Z" fill="#64748B" />
                                        </svg>
                                    </span>
                                    <span class="multi-pin" changeWith="1">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.3908 4.36734L12.1481 8.60998L7.90549 10.0242L6.49128 11.4384L13.5623 18.5095L14.9766 17.0953L16.3908 12.8526L20.6334 8.60998" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10.0234 14.9746L6.4879 18.5101" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M15.6797 3.66211L21.3365 9.31896" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <span class="multi-mute" changeWith="1">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.5 8.36979V7.40979C15.5 4.42979 13.43 3.28979 10.91 4.86979L7.99 6.69979C7.67 6.88979 7.3 6.99979 6.93 6.99979H5.5C3.5 6.99979 2.5 7.99979 2.5 9.99979V13.9998C2.5 15.9998 3.5 16.9998 5.5 16.9998H7.5" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10.9062 19.1292C13.4262 20.7092 15.4963 19.5592 15.4963 16.5892V12.9492" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M19.31 9.41992C20.21 11.5699 19.94 14.0799 18.5 15.9999" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M21.6481 7.80078C23.1181 11.2908 22.6781 15.3708 20.3281 18.5008" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M22.5 2L2.5 22" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <span class="multi-archive" changeWith="1">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20 9.2207V18.0007C20 20.0007 19.5 21.0007 17 21.0007H8C5.5 21.0007 5 20.0007 5 18.0007V9.2207" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.5 4H19.5C21.5 4 22.5 4.625 22.5 5.875V7.125C22.5 8.375 21.5 9 19.5 9H5.5C3.5 9 2.5 8.375 2.5 7.125V5.875C2.5 4.625 3.5 4 5.5 4Z" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10.6797 13H14.3197" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <span class="multi-delete">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.5036 6.73046C21.4836 6.73046 21.4536 6.73046 21.4236 6.73046C16.1336 6.20046 10.8536 6.00046 5.62358 6.53046L3.58358 6.73046C3.16358 6.77046 2.79358 6.47046 2.75358 6.05046C2.71358 5.63046 3.01358 5.27046 3.42358 5.23046L5.46358 5.03046C10.7836 4.49046 16.1736 4.70046 21.5736 5.23046C21.9836 5.27046 22.2836 5.64046 22.2436 6.05046C22.2136 6.44046 21.8836 6.73046 21.5036 6.73046Z" fill="#64748B" />
                                            <path d="M9.00074 5.72C8.96074 5.72 8.92074 5.72 8.87074 5.71C8.47074 5.64 8.19074 5.25 8.26074 4.85L8.48074 3.54C8.64074 2.58 8.86074 1.25 11.1907 1.25H13.8107C16.1507 1.25 16.3707 2.63 16.5207 3.55L16.7407 4.85C16.8107 5.26 16.5307 5.65 16.1307 5.71C15.7207 5.78 15.3307 5.5 15.2707 5.1L15.0507 3.8C14.9107 2.93 14.8807 2.76 13.8207 2.76H11.2007C10.1407 2.76 10.1207 2.9 9.97074 3.79L9.74074 5.09C9.68074 5.46 9.36074 5.72 9.00074 5.72Z" fill="#64748B" />
                                            <path d="M15.7104 22.7496H9.29039C5.80039 22.7496 5.66039 20.8196 5.55039 19.2596L4.90039 9.18959C4.87039 8.77959 5.19039 8.41959 5.60039 8.38959C6.02039 8.36959 6.37039 8.67959 6.40039 9.08959L7.05039 19.1596C7.16039 20.6796 7.20039 21.2496 9.29039 21.2496H15.7104C17.8104 21.2496 17.8504 20.6796 17.9504 19.1596L18.6004 9.08959C18.6304 8.67959 18.9904 8.36959 19.4004 8.38959C19.8104 8.41959 20.1304 8.76959 20.1004 9.18959L19.4504 19.2596C19.3404 20.8196 19.2004 22.7496 15.7104 22.7496Z" fill="#64748B" />
                                            <path d="M14.1581 17.25H10.8281C10.4181 17.25 10.0781 16.91 10.0781 16.5C10.0781 16.09 10.4181 15.75 10.8281 15.75H14.1581C14.5681 15.75 14.9081 16.09 14.9081 16.5C14.9081 16.91 14.5681 17.25 14.1581 17.25Z" fill="#64748B" />
                                            <path d="M15 13.25H10C9.59 13.25 9.25 12.91 9.25 12.5C9.25 12.09 9.59 11.75 10 11.75H15C15.41 11.75 15.75 12.09 15.75 12.5C15.75 12.91 15.41 13.25 15 13.25Z" fill="#64748B" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="dropdown ms-3">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                    <svg width="5" height="18" viewBox="0 0 5 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.5 9C1.5 9.26522 1.60536 9.51957 1.79289 9.70711C1.98043 9.89464 2.23478 10 2.5 10C2.76522 10 3.01957 9.89464 3.20711 9.70711C3.39464 9.51957 3.5 9.26522 3.5 9C3.5 8.73478 3.39464 8.48043 3.20711 8.29289C3.01957 8.10536 2.76522 8 2.5 8C2.23478 8 1.98043 8.10536 1.79289 8.29289C1.60536 8.48043 1.5 8.73478 1.5 9Z" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M1.5 16C1.5 16.2652 1.60536 16.5196 1.79289 16.7071C1.98043 16.8946 2.23478 17 2.5 17C2.76522 17 3.01957 16.8946 3.20711 16.7071C3.39464 16.5196 3.5 16.2652 3.5 16C3.5 15.7348 3.39464 15.4804 3.20711 15.2929C3.01957 15.1054 2.76522 15 2.5 15C2.23478 15 1.98043 15.1054 1.79289 15.2929C1.60536 15.4804 1.5 15.7348 1.5 16Z" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M1.5 2C1.5 2.26522 1.60536 2.51957 1.79289 2.70711C1.98043 2.89464 2.23478 3 2.5 3C2.76522 3 3.01957 2.89464 3.20711 2.70711C3.39464 2.51957 3.5 2.26522 3.5 2C3.5 1.73478 3.39464 1.48043 3.20711 1.29289C3.01957 1.10536 2.76522 1 2.5 1C2.23478 1 1.98043 1.10536 1.79289 1.29289C1.60536 1.48043 1.5 1.73478 1.5 2Z" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="bulk-edit"><a class="dropdown-item" href="#"><svg class="me-2" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.499 13.6092C8.50729 13.6092 6.89062 11.9926 6.89062 10.0009C6.89062 8.00924 8.50729 6.39258 10.499 6.39258C12.4906 6.39258 14.1073 8.00924 14.1073 10.0009C14.1073 11.9926 12.4906 13.6092 10.499 13.6092ZM10.499 7.64258C9.19896 7.64258 8.14062 8.70091 8.14062 10.0009C8.14062 11.3009 9.19896 12.3592 10.499 12.3592C11.799 12.3592 12.8573 11.3009 12.8573 10.0009C12.8573 8.70091 11.799 7.64258 10.499 7.64258Z" fill="#94A3B8" />
                                                <path d="M10.4984 17.5158C7.3651 17.5158 4.40677 15.6824 2.37344 12.4991C1.4901 11.1241 1.4901 8.88242 2.37344 7.49909C4.4151 4.31576 7.37344 2.48242 10.4984 2.48242C13.6234 2.48242 16.5818 4.31576 18.6151 7.49909C19.4984 8.87409 19.4984 11.1158 18.6151 12.4991C16.5818 15.6824 13.6234 17.5158 10.4984 17.5158ZM10.4984 3.73242C7.80677 3.73242 5.23177 5.34909 3.43177 8.17409C2.80677 9.14909 2.80677 10.8491 3.43177 11.8241C5.23177 14.6491 7.80677 16.2658 10.4984 16.2658C13.1901 16.2658 15.7651 14.6491 17.5651 11.8241C18.1901 10.8491 18.1901 9.14909 17.5651 8.17409C15.7651 5.34909 13.1901 3.73242 10.4984 3.73242Z" fill="#94A3B8" />
                                            </svg>
                                            Bulk Edit</a></li>
                                </ul>
                            </div>
                        </div>
                        <input type="hidden" class="senderUser" id="senderUser" value="{{$userId}}" />
                        <input type="hidden" class="senderUserName" value="{{$userName}}" />
                        <ul class="chat-list">
                            
                        @php
                        $i = 0;
                    @endphp
                @foreach ($messages as $k => $message)
                    @if(!isset($message['contactName']))
                        @continue
                    @endisset
                    @if ($i == 0 && @$message['isArchive']!="1")
                        <input type="hidden" class="selected_id" value="{{$k}}"/>
                        <input type="hidden" class="selected_message" value="{{$message['contactId']}}"/>
                        <input type="hidden" class="selected_name" value="{{$message['contactName']}}"/>
                        <input type="hidden" id="isGroup" value="{{@$message['group']}}"/>
                    @endif
                    <div>
                        <li class="{{$i == 0 ?'active':''}} msg-list conversation-{{$message['conversationId']}} {{@$message['isArchive']=="1"?"archived-list":"unarchived-list"}}" data-userId="{{$message['contactId']}}" data-msgKey={{$k}} data-group={{@$message['group']}}>
                        <div class="me-2 d-none bulk-check">
                            <input class="form-check-input" type="checkbox" name="checked_conversation[]" value="{{$message['conversationId']}}" isGroup="{{@$message['group']}}">
                        </div>
                        
                        <div class="chat-data d-flex align-items-center">
                            <div class="user-img position-relative">
                            @if($message['receiverProfile']!=="")
                                                        <img class="img-fluid user-image user-img-{{$message['contactId']}}" data-id={{$message['contactId']}} src="{{$message['receiverProfile']}}" alt="user img">
                                                        @else
                                                        @php
                                                        $contactName = $message['contactName'];
                                                        $words = explode(' ', $contactName);
                                                        $initials = '';
                                                        foreach ($words as $word) {
                                                            $initials .= strtoupper(substr($word, 0, 1));
                                                        }
                                                        $fontColor = "fontcolor" . strtoupper($initials[0]);
                                                        @endphp
                                                        <h5 class="{{$fontColor}}">{{$initials}}</h5>
                                                        @endif
                                <span class="active"></span>
                            </div>
                            <a href="#" class="user-detail d-block ms-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3>{{$message['contactName']}}</h3>
                                    @php
                                        $timestamp = $message['timeStamp'] ?? now()->timestamp;
                                        $timeAgo = Carbon::createFromTimestampMs($timestamp)->diffForHumans();
                                    @endphp
                                    <h6 class="ms-2 time-ago"> {{ $timeAgo }}</h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="last-message">{{$message['lastMessage']}}</span>
                                    <span class="badge ms-2 {{@$message['unReadCount'] == 0 ? 'd-none' : ''}}">{{@$message['unReadCount']}}</span>
                                </div>
                            </a>
                            <span class="ms-3 me-2 d-flex align-items-center pin-svg {{@$message['isPin']=='1'?'':'d-none'}}">
                                <svg width="11" height="17" viewBox="0 0 11 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.83333 0.5C9.04573 0.500236 9.25003 0.581566 9.40447 0.727374C9.55892 0.873181 9.65186 1.07246 9.66431 1.2845C9.67676 1.49653 9.60777 1.70532 9.47145 1.86819C9.33512 2.03107 9.14175 2.13575 8.93083 2.16083L8.83333 2.16667V6.13667L10.4117 9.29417C10.4552 9.38057 10.4834 9.47391 10.495 9.57L10.5 9.66667V11.3333C10.5 11.5374 10.425 11.7344 10.2894 11.887C10.1538 12.0395 9.96688 12.137 9.76417 12.1608L9.66667 12.1667H6.33333V15.5C6.3331 15.7124 6.25177 15.9167 6.10596 16.0711C5.96015 16.2256 5.76087 16.3185 5.54884 16.331C5.3368 16.3434 5.12802 16.2744 4.96514 16.1381C4.80226 16.0018 4.69759 15.8084 4.6725 15.5975L4.66667 15.5V12.1667H1.33333C1.12922 12.1666 0.932219 12.0917 0.77969 11.9561C0.627161 11.8204 0.529714 11.6335 0.505833 11.4308L0.5 11.3333V9.66667C0.500114 9.57004 0.517032 9.47416 0.55 9.38333L0.588333 9.29417L2.16667 6.135V2.16667C1.95427 2.16643 1.74997 2.0851 1.59553 1.93929C1.44108 1.79349 1.34814 1.59421 1.33569 1.38217C1.32324 1.17014 1.39223 0.96135 1.52855 0.798473C1.66488 0.635595 1.85825 0.53092 2.06917 0.505833L2.16667 0.5H8.83333Z" fill="#94A3B8"/>
                                </svg>
                            </span>
                             {{-- <div class="dropdown ms-auto">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                    <svg width="5" height="18" viewBox="0 0 5 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.5 9C1.5 9.26522 1.60536 9.51957 1.79289 9.70711C1.98043 9.89464 2.23478 10 2.5 10C2.76522 10 3.01957 9.89464 3.20711 9.70711C3.39464 9.51957 3.5 9.26522 3.5 9C3.5 8.73478 3.39464 8.48043 3.20711 8.29289C3.01957 8.10536 2.76522 8 2.5 8C2.23478 8 1.98043 8.10536 1.79289 8.29289C1.60536 8.48043 1.5 8.73478 1.5 9Z" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.5 16C1.5 16.2652 1.60536 16.5196 1.79289 16.7071C1.98043 16.8946 2.23478 17 2.5 17C2.76522 17 3.01957 16.8946 3.20711 16.7071C3.39464 16.5196 3.5 16.2652 3.5 16C3.5 15.7348 3.39464 15.4804 3.20711 15.2929C3.01957 15.1054 2.76522 15 2.5 15C2.23478 15 1.98043 15.1054 1.79289 15.2929C1.60536 15.4804 1.5 15.7348 1.5 16Z" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.5 2C1.5 2.26522 1.60536 2.51957 1.79289 2.70711C1.98043 2.89464 2.23478 3 2.5 3C2.76522 3 3.01957 2.89464 3.20711 2.70711C3.39464 2.51957 3.5 2.26522 3.5 2C3.5 1.73478 3.39464 1.48043 3.20711 1.29289C3.01957 1.10536 2.76522 1 2.5 1C2.23478 1 1.98043 1.10536 1.79289 1.29289C1.60536 1.48043 1.5 1.73478 1.5 2Z" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                               <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul> 
                            </div>--}}
                        </div>
                    </li>
                </div>
                    @php
                    if(@$message['isArchive']!="1"){
                        $i++;
                    }
                    @endphp
                @endforeach
                    @if ($i==0)
                    <input type="hidden" class="selected_id"/>
                    <input type="hidden" class="selected_message" />
                    <input type="hidden" class="selected_name"/>
                    <input type="hidden" id="isGroup"/>

                    @endif
                    <button id="archive-list" list="0">Archive List</button>
                        </ul>
                    </div>
                    <div class="chatbox position-relative w-100">
                        <div class="msg-head">
                            <div class="row">
                                <div class="col-lg-8 col-7">
                                    <a href="javascript:;" class="d-flex conversationId" data-bs-toggle="modal" data-bs-target="#listBox">
                                        <div class="user-img">
                                            <img id="selected-user-profile" src="{{asset('assets/front')}}/image/user-img.svg" alt="user-img">
                                        </div>
                                        <div class="user-detail">
                                            <h3 id="selected-user-name">Start new chat</h3>
                                            <span id="selected-user-lastseen"></span>
                                            <span class="typing"></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-5">
                                    <div class="dropdown ms-auto text-end">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                            <svg width="5" height="18" viewBox="0 0 5 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 9C1.5 9.26522 1.60536 9.51957 1.79289 9.70711C1.98043 9.89464 2.23478 10 2.5 10C2.76522 10 3.01957 9.89464 3.20711 9.70711C3.39464 9.51957 3.5 9.26522 3.5 9C3.5 8.73478 3.39464 8.48043 3.20711 8.29289C3.01957 8.10536 2.76522 8 2.5 8C2.23478 8 1.98043 8.10536 1.79289 8.29289C1.60536 8.48043 1.5 8.73478 1.5 9Z" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M1.5 16C1.5 16.2652 1.60536 16.5196 1.79289 16.7071C1.98043 16.8946 2.23478 17 2.5 17C2.76522 17 3.01957 16.8946 3.20711 16.7071C3.39464 16.5196 3.5 16.2652 3.5 16C3.5 15.7348 3.39464 15.4804 3.20711 15.2929C3.01957 15.1054 2.76522 15 2.5 15C2.23478 15 1.98043 15.1054 1.79289 15.2929C1.60536 15.4804 1.5 15.7348 1.5 16Z" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M1.5 2C1.5 2.26522 1.60536 2.51957 1.79289 2.70711C1.98043 2.89464 2.23478 3 2.5 3C2.76522 3 3.01957 2.89464 3.20711 2.70711C3.39464 2.51957 3.5 2.26522 3.5 2C3.5 1.73478 3.39464 1.48043 3.20711 1.29289C3.01957 1.10536 2.76522 1 2.5 1C2.23478 1 1.98043 1.10536 1.79289 1.29289C1.60536 1.48043 1.5 1.73478 1.5 2Z" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                            {{-- <li><a class="dropdown-item" href="#"><svg class="me-2" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.5019 16.3299C10.1119 16.3299 8.17188 14.3899 8.17188 11.9999C8.17188 9.60992 10.1119 7.66992 12.5019 7.66992C14.8919 7.66992 16.8319 9.60992 16.8319 11.9999C16.8319 14.3899 14.8919 16.3299 12.5019 16.3299ZM12.5019 9.16992C10.9419 9.16992 9.67188 10.4399 9.67188 11.9999C9.67188 13.5599 10.9419 14.8299 12.5019 14.8299C14.0619 14.8299 15.3319 13.5599 15.3319 11.9999C15.3319 10.4399 14.0619 9.16992 12.5019 9.16992Z" fill="#64748B" />
                                                        <path d="M12.4981 21.0205C8.73812 21.0205 5.18813 18.8205 2.74812 15.0005C1.68813 13.3505 1.68813 10.6605 2.74812 9.00047C5.19812 5.18047 8.74813 2.98047 12.4981 2.98047C16.2481 2.98047 19.7981 5.18047 22.2381 9.00047C23.2981 10.6505 23.2981 13.3405 22.2381 15.0005C19.7981 18.8205 16.2481 21.0205 12.4981 21.0205ZM12.4981 4.48047C9.26813 4.48047 6.17813 6.42047 4.01813 9.81047C3.26813 10.9805 3.26813 13.0205 4.01813 14.1905C6.17813 17.5805 9.26813 19.5205 12.4981 19.5205C15.7281 19.5205 18.8181 17.5805 20.9781 14.1905C21.7281 13.0205 21.7281 10.9805 20.9781 9.81047C18.8181 6.42047 15.7281 4.48047 12.4981 4.48047Z" fill="#64748B" />
                                                    </svg> Mark as read </a></li> --}}
                                            <li>
                                                <a class="dropdown-item pin-conversation" href="#">

                                                    <svg class="me-2" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.3908 4.36734L12.1481 8.60998L7.90549 10.0242L6.49128 11.4384L13.5623 18.5095L14.9766 17.0953L16.3908 12.8526L20.6334 8.60998" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M10.0234 14.9746L6.4879 18.5101" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M15.6797 3.66211L21.3365 9.31896" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>

                                                    <span>Pin</span></a>
                                            </li>
                                            <li><a class="dropdown-item mute-conversation" href="#">
                                                    <svg class="me-2" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.33073 14.7926H4.66406C2.6474 14.7926 1.53906 13.6843 1.53906 11.6676V8.33428C1.53906 6.31762 2.6474 5.20928 4.66406 5.20928H5.85573C6.0474 5.20928 6.23906 5.15095 6.40573 5.05095L8.83906 3.52595C10.0557 2.76762 11.2391 2.62595 12.1724 3.14262C13.1057 3.65928 13.6141 4.73428 13.6141 6.17595V6.97595C13.6141 7.31762 13.3307 7.60095 12.9891 7.60095C12.6474 7.60095 12.3641 7.31762 12.3641 6.97595V6.17595C12.3641 5.22595 12.0724 4.51762 11.5641 4.24262C11.0557 3.95928 10.3057 4.08428 9.4974 4.59262L7.06406 6.10928C6.70573 6.34262 6.28073 6.45928 5.85573 6.45928H4.66406C3.3474 6.45928 2.78906 7.01762 2.78906 8.33428V11.6676C2.78906 12.9843 3.3474 13.5426 4.66406 13.5426H6.33073C6.6724 13.5426 6.95573 13.826 6.95573 14.1676C6.95573 14.5093 6.6724 14.7926 6.33073 14.7926Z" fill="#94A3B8" />
                                                        <path d="M10.9577 17.1577C10.2993 17.1577 9.57434 16.9244 8.84934 16.466C8.55767 16.2827 8.46601 15.8993 8.64934 15.6077C8.83267 15.316 9.21601 15.2243 9.50767 15.4077C10.316 15.9077 11.066 16.041 11.5743 15.7577C12.0827 15.4743 12.3743 14.766 12.3743 13.8243V10.791C12.3743 10.4493 12.6577 10.166 12.9993 10.166C13.341 10.166 13.6243 10.4493 13.6243 10.791V13.8243C13.6243 15.2577 13.1077 16.341 12.1827 16.8577C11.8077 17.0577 11.391 17.1577 10.9577 17.1577Z" fill="#94A3B8" />
                                                        <path d="M15.5002 13.9586C15.3669 13.9586 15.2419 13.9169 15.1252 13.8336C14.8502 13.6253 14.7919 13.2336 15.0002 12.9586C16.0502 11.5586 16.2752 9.70026 15.6002 8.09193C15.4669 7.77526 15.6169 7.4086 15.9336 7.27526C16.2502 7.14193 16.6169 7.29193 16.7502 7.6086C17.6002 9.62526 17.3086 11.9669 16.0002 13.7169C15.8752 13.8753 15.6919 13.9586 15.5002 13.9586Z" fill="#94A3B8" />
                                                        <path d="M17.0237 16.0423C16.8903 16.0423 16.7653 16.0007 16.6487 15.9173C16.3737 15.709 16.3153 15.3173 16.5237 15.0423C18.307 12.6673 18.6987 9.48399 17.5487 6.74232C17.4153 6.42565 17.5653 6.05899 17.882 5.92565C18.207 5.79232 18.5653 5.94232 18.6987 6.25899C20.0237 9.40899 19.5737 13.059 17.5237 15.7923C17.407 15.959 17.2153 16.0423 17.0237 16.0423Z" fill="#94A3B8" />
                                                        <path d="M2.16979 18.9576C2.01146 18.9576 1.85313 18.8992 1.72812 18.7742C1.48646 18.5326 1.48646 18.1325 1.72812 17.8909L18.3948 1.22422C18.6365 0.982552 19.0365 0.982552 19.2781 1.22422C19.5198 1.46589 19.5198 1.86589 19.2781 2.10755L2.61146 18.7742C2.48646 18.8992 2.32812 18.9576 2.16979 18.9576Z" fill="#94A3B8" />
                                                    </svg>
                                                    <span>Mute</span></a>
                                            </li>
                                            <li><a class="dropdown-item archive-conversation" href="#">
                                                    <svg class="me-2" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.75 7.68359V15.0003C16.75 16.6669 16.3333 17.5003 14.25 17.5003H6.75C4.66667 17.5003 4.25 16.6669 4.25 15.0003V7.68359" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M4.66406 3.33398H16.3307C17.9974 3.33398 18.8307 3.85482 18.8307 4.89648V5.93815C18.8307 6.97982 17.9974 7.50065 16.3307 7.50065H4.66406C2.9974 7.50065 2.16406 6.97982 2.16406 5.93815V4.89648C2.16406 3.85482 2.9974 3.33398 4.66406 3.33398Z" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M8.98438 10.834H12.0177" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <span>Archive</span></a>
                                            </li>
                                            <li><a class="dropdown-item delete-conversation" href="#">
                                                    <svg class="me-2" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M18.003 5.60742C17.9863 5.60742 17.9613 5.60742 17.9363 5.60742C13.528 5.16575 9.12798 4.99909 4.76965 5.44075L3.06965 5.60742C2.71965 5.64075 2.41131 5.39075 2.37798 5.04075C2.34465 4.69075 2.59465 4.39075 2.93631 4.35742L4.63631 4.19075C9.06965 3.74075 13.5613 3.91575 18.0613 4.35742C18.403 4.39075 18.653 4.69909 18.6196 5.04075C18.5946 5.36575 18.3196 5.60742 18.003 5.60742Z" fill="#94A3B8" />
                                                        <path d="M7.58656 4.76602C7.55322 4.76602 7.51989 4.76602 7.47822 4.75768C7.14489 4.69935 6.91156 4.37435 6.96989 4.04102L7.15322 2.94935C7.28656 2.14935 7.46989 1.04102 9.41156 1.04102H11.5949C13.5449 1.04102 13.7282 2.19102 13.8532 2.95768L14.0366 4.04102C14.0949 4.38268 13.8616 4.70768 13.5282 4.75768C13.1866 4.81602 12.8616 4.58268 12.8116 4.24935L12.6282 3.16602C12.5116 2.44102 12.4866 2.29935 11.6032 2.29935H9.41989C8.53656 2.29935 8.51989 2.41602 8.39489 3.15768L8.20322 4.24102C8.15322 4.54935 7.88656 4.76602 7.58656 4.76602Z" fill="#94A3B8" />
                                                        <path d="M13.174 18.9577H7.82402C4.91569 18.9577 4.79902 17.3493 4.70735 16.0493L4.16569 7.65766C4.14069 7.316 4.40735 7.016 4.74902 6.991C5.09902 6.97433 5.39069 7.23266 5.41569 7.57433L5.95735 15.966C6.04902 17.2327 6.08235 17.7077 7.82402 17.7077H13.174C14.924 17.7077 14.9574 17.2327 15.0407 15.966L15.5824 7.57433C15.6074 7.23266 15.9074 6.97433 16.249 6.991C16.5907 7.016 16.8574 7.30766 16.8324 7.65766L16.2907 16.0493C16.199 17.3493 16.0824 18.9577 13.174 18.9577Z" fill="#94A3B8" />
                                                        <path d="M11.8844 14.375H9.10938C8.76771 14.375 8.48438 14.0917 8.48438 13.75C8.48438 13.4083 8.76771 13.125 9.10938 13.125H11.8844C12.226 13.125 12.5094 13.4083 12.5094 13.75C12.5094 14.0917 12.226 14.375 11.8844 14.375Z" fill="#94A3B8" />
                                                        <path d="M12.5807 11.041H8.41406C8.0724 11.041 7.78906 10.7577 7.78906 10.416C7.78906 10.0743 8.0724 9.79102 8.41406 9.79102H12.5807C12.9224 9.79102 13.2057 10.0743 13.2057 10.416C13.2057 10.7577 12.9224 11.041 12.5807 11.041Z" fill="#94A3B8" />
                                                    </svg>
                                                    Delete</a>
                                            </li>
                                            <li><a class="dropdown-item block-conversation" href="#">
                                                    <svg class="me-2" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.9141 18.9577H8.08073C7.33907 18.9577 6.38906 18.566 5.87239 18.041L2.45573 14.6243C1.93073 14.0993 1.53906 13.1493 1.53906 12.416V7.58269C1.53906 6.84102 1.93073 5.89103 2.45573 5.37436L5.87239 1.95769C6.39739 1.43269 7.3474 1.04102 8.08073 1.04102H12.9141C13.6557 1.04102 14.6057 1.43269 15.1224 1.95769L18.5391 5.37436C19.0641 5.89936 19.4557 6.84935 19.4557 7.58269V12.416C19.4557 13.1577 19.0641 14.1077 18.5391 14.6243L15.1224 18.041C14.5974 18.566 13.6557 18.9577 12.9141 18.9577ZM8.08073 2.29102C7.6724 2.29102 7.03906 2.54935 6.75572 2.84102L3.33907 6.25769C3.05573 6.54936 2.78906 7.17435 2.78906 7.58269V12.416C2.78906 12.8243 3.0474 13.4577 3.33907 13.741L6.75572 17.1577C7.04739 17.441 7.6724 17.7077 8.08073 17.7077H12.9141C13.3224 17.7077 13.9557 17.4493 14.2391 17.1577L17.6557 13.741C17.9391 13.4493 18.2057 12.8243 18.2057 12.416V7.58269C18.2057 7.17435 17.9474 6.54102 17.6557 6.25769L14.2391 2.84102C13.9474 2.55769 13.3224 2.29102 12.9141 2.29102H8.08073Z" fill="#94A3B8" />
                                                        <path d="M4.6151 16.5254C4.45677 16.5254 4.29844 16.467 4.17344 16.342C3.93177 16.1004 3.93177 15.7004 4.17344 15.4587L15.9568 3.67539C16.1984 3.43372 16.5984 3.43372 16.8401 3.67539C17.0818 3.91706 17.0818 4.31706 16.8401 4.55872L5.05677 16.342C4.93177 16.467 4.77344 16.5254 4.6151 16.5254Z" fill="#94A3B8" />
                                                    </svg>
                                                    <span>Block User<span></a>
                                            </li>
                                            <li><a class="dropdown-item report-conversation" href="#">
                                                    <svg class="me-2" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.4974 18.9577C5.55573 18.9577 1.53906 14.941 1.53906 9.99935C1.53906 5.05768 5.55573 1.04102 10.4974 1.04102C15.4391 1.04102 19.4557 5.05768 19.4557 9.99935C19.4557 14.941 15.4391 18.9577 10.4974 18.9577ZM10.4974 2.29102C6.2474 2.29102 2.78906 5.74935 2.78906 9.99935C2.78906 14.2493 6.2474 17.7077 10.4974 17.7077C14.7474 17.7077 18.2057 14.2493 18.2057 9.99935C18.2057 5.74935 14.7474 2.29102 10.4974 2.29102Z" fill="#94A3B8" />
                                                        <path d="M10.5 11.4577C10.1583 11.4577 9.875 11.1743 9.875 10.8327V6.66602C9.875 6.32435 10.1583 6.04102 10.5 6.04102C10.8417 6.04102 11.125 6.32435 11.125 6.66602V10.8327C11.125 11.1743 10.8417 11.4577 10.5 11.4577Z" fill="#94A3B8" />
                                                        <path d="M10.4974 14.1664C10.3891 14.1664 10.2807 14.1414 10.1807 14.0997C10.0807 14.0581 9.98906 13.9997 9.90573 13.9247C9.83073 13.8414 9.7724 13.7581 9.73073 13.6497C9.68906 13.5497 9.66406 13.4414 9.66406 13.3331C9.66406 13.2247 9.68906 13.1164 9.73073 13.0164C9.7724 12.9164 9.83073 12.8247 9.90573 12.7414C9.98906 12.6664 10.0807 12.6081 10.1807 12.5664C10.3807 12.4831 10.6141 12.4831 10.8141 12.5664C10.9141 12.6081 11.0057 12.6664 11.0891 12.7414C11.1641 12.8247 11.2224 12.9164 11.2641 13.0164C11.3057 13.1164 11.3307 13.2247 11.3307 13.3331C11.3307 13.4414 11.3057 13.5497 11.2641 13.6497C11.2224 13.7581 11.1641 13.8414 11.0891 13.9247C11.0057 13.9997 10.9141 14.0581 10.8141 14.0997C10.7141 14.1414 10.6057 14.1664 10.4974 14.1664Z" fill="#94A3B8" />
                                                    </svg>
                                                    Report</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="msg-body" id="msgBody">
                            <input type="hidden" class="selected_conversasion" />

                            <ul class="msg-lists">

                            </ul>
                            <div id="msgbox"></div>
                            <!-- <div class="empty-massage">
                                <div class="empty-img">
                                    <img src="./assets/image/empty-img.png" alt="empty-img">
                                </div>
                                <h5>Select Message First</h5>
                                <p>Please select a message to see the details</p>
                            </div> -->

                            
                        </div>

                      
                        <div id="preview"></div>
                        <label id="upload_name"></label>
                        <img src="" id="preview_img" class="preview_img">
                        <div id="preview_file">
                            <button class="file_close">X</button>
                            <img src="{{asset('storage/file.png')}}" class="preview_file">
                            <span id="file_name"></span>
                        </div>
                        <input type="hidden" class="file_info">

                        <div class="msg-footer">
                            <div class="message-perent">
                                <input type="text" placeholder="Write message here..." class="send-message">
                                <div class="d-flex gap-3">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-primary dropdown-toggle p-0" data-bs-toggle="dropdown">
                                            <svg class="me-2" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.7028 11.8002L11.2928 13.2102C10.5128 13.9902 10.5128 15.2602 11.2928 16.0402C12.0728 16.8202 13.3428 16.8202 14.1228 16.0402L16.3428 13.8202C17.9028 12.2602 17.9028 9.73023 16.3428 8.16023C14.7828 6.60023 12.2528 6.60023 10.6828 8.16023L8.26281 10.5802C6.92281 11.9202 6.92281 14.0902 8.26281 15.4302" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.5 22C18.0228 22 22.5 17.5228 22.5 12C22.5 6.47715 18.0228 2 12.5 2C6.97715 2 2.5 6.47715 2.5 12C2.5 17.5228 6.97715 22 12.5 22Z" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#" class="button-wrapper">
                                                    <span class="label">
                                                        <svg class="me-2" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M14.8667 18.9577H6.1334C3.80006 18.9577 2.31673 17.566 2.1834 15.241L1.75006 8.36602C1.6834 7.32435 2.04173 6.32435 2.7584 5.56602C3.46673 4.80768 4.46673 4.37435 5.50006 4.37435C5.76673 4.37435 6.02506 4.21602 6.15006 3.96602L6.75006 2.77435C7.24173 1.79935 8.47506 1.04102 9.55006 1.04102H11.4584C12.5334 1.04102 13.7584 1.79935 14.2501 2.76602L14.8501 3.98268C14.9751 4.21602 15.2251 4.37435 15.5001 4.37435C16.5334 4.37435 17.5334 4.80768 18.2417 5.56602C18.9584 6.33268 19.3167 7.32435 19.2501 8.36602L18.8167 15.2493C18.6667 17.6077 17.2251 18.9577 14.8667 18.9577ZM9.55006 2.29102C8.9334 2.29102 8.15006 2.77435 7.86673 3.33268L7.26673 4.53268C6.91673 5.20768 6.24173 5.62435 5.50006 5.62435C4.80006 5.62435 4.15006 5.90768 3.66673 6.41602C3.19173 6.92435 2.95006 7.59102 3.00006 8.28268L3.4334 15.166C3.5334 16.8493 4.44173 17.7077 6.1334 17.7077H14.8667C16.5501 17.7077 17.4584 16.8493 17.5667 15.166L18.0001 8.28268C18.0417 7.59102 17.8084 6.92435 17.3334 6.41602C16.8501 5.90768 16.2001 5.62435 15.5001 5.62435C14.7584 5.62435 14.0834 5.20768 13.7334 4.54935L13.1251 3.33268C12.8501 2.78268 12.0667 2.29935 11.4501 2.29935H9.55006V2.29102Z" fill="#64748B" />
                                                            <path d="M11.75 7.29102H9.25C8.90833 7.29102 8.625 7.00768 8.625 6.66602C8.625 6.32435 8.90833 6.04102 9.25 6.04102H11.75C12.0917 6.04102 12.375 6.32435 12.375 6.66602C12.375 7.00768 12.0917 7.29102 11.75 7.29102Z" fill="#64748B" />
                                                            <path d="M10.4974 15.6257C8.65573 15.6257 7.16406 14.134 7.16406 12.2923C7.16406 10.4507 8.65573 8.95898 10.4974 8.95898C12.3391 8.95898 13.8307 10.4507 13.8307 12.2923C13.8307 14.134 12.3391 15.6257 10.4974 15.6257ZM10.4974 10.209C9.3474 10.209 8.41406 11.1423 8.41406 12.2923C8.41406 13.4423 9.3474 14.3757 10.4974 14.3757C11.6474 14.3757 12.5807 13.4423 12.5807 12.2923C12.5807 11.1423 11.6474 10.209 10.4974 10.209Z" fill="#64748B" />
                                                        </svg> Camera
                                                    </span>
                                                    <input type="file" name="upload" id="upload" class="upload-box" placeholder="Upload File" aria-label="Upload File">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="button-wrapper">
                                                    <span class="label">
                                                        <svg class="me-2" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.9974 18.9577H7.9974C3.4724 18.9577 1.53906 17.0243 1.53906 12.4993V7.49935C1.53906 2.97435 3.4724 1.04102 7.9974 1.04102H12.9974C17.5224 1.04102 19.4557 2.97435 19.4557 7.49935V12.4993C19.4557 17.0243 17.5224 18.9577 12.9974 18.9577ZM7.9974 2.29102C4.15573 2.29102 2.78906 3.65768 2.78906 7.49935V12.4993C2.78906 16.341 4.15573 17.7077 7.9974 17.7077H12.9974C16.8391 17.7077 18.2057 16.341 18.2057 12.4993V7.49935C18.2057 3.65768 16.8391 2.29102 12.9974 2.29102H7.9974Z" fill="#64748B" />
                                                            <path d="M8.0026 8.95833C6.73594 8.95833 5.71094 7.93333 5.71094 6.66667C5.71094 5.4 6.73594 4.375 8.0026 4.375C9.26927 4.375 10.2943 5.4 10.2943 6.66667C10.2943 7.93333 9.26927 8.95833 8.0026 8.95833ZM8.0026 5.625C7.4276 5.625 6.96094 6.09167 6.96094 6.66667C6.96094 7.24167 7.4276 7.70833 8.0026 7.70833C8.5776 7.70833 9.04427 7.24167 9.04427 6.66667C9.04427 6.09167 8.5776 5.625 8.0026 5.625Z" fill="#64748B" />
                                                            <path d="M2.724 16.4168C2.524 16.4168 2.324 16.3168 2.20733 16.1418C2.01566 15.8585 2.09066 15.4668 2.38233 15.2751L6.49066 12.5168C7.39066 11.9085 8.63233 11.9835 9.449 12.6751L9.724 12.9168C10.1407 13.2751 10.849 13.2751 11.2573 12.9168L14.724 9.9418C15.6073 9.18346 16.999 9.18346 17.8907 9.9418L19.249 11.1085C19.5073 11.3335 19.5407 11.7251 19.3157 11.9918C19.0907 12.2501 18.699 12.2835 18.4323 12.0585L17.074 10.8918C16.6573 10.5335 15.949 10.5335 15.5323 10.8918L12.0657 13.8668C11.1823 14.6251 9.79066 14.6251 8.899 13.8668L8.624 13.6251C8.24066 13.3001 7.60733 13.2668 7.18233 13.5585L3.074 16.3168C2.96566 16.3835 2.84066 16.4168 2.724 16.4168Z" fill="#64748B" />
                                                        </svg> Gallery
                                                    </span>
                                                    <input type="file" name="upload" id="upload" class="upload-box" placeholder="Upload File" aria-label="Upload File">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="button-wrapper">
                                                    <span class="label">
                                                        <svg class="me-2" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M8.00052 14.7917C7.65885 14.7917 7.37552 14.5084 7.37552 14.1667V10.6751L6.77552 11.2751C6.53385 11.5167 6.13385 11.5167 5.89219 11.2751C5.65052 11.0334 5.65052 10.6334 5.89219 10.3917L7.55885 8.72507C7.73385 8.55007 8.00885 8.49174 8.24219 8.59174C8.47552 8.68341 8.62552 8.91674 8.62552 9.16674V14.1667C8.62552 14.5084 8.34219 14.7917 8.00052 14.7917Z" fill="#64748B" />
                                                            <path d="M9.66458 11.4576C9.50625 11.4576 9.34792 11.3992 9.22292 11.2742L7.55625 9.60755C7.31458 9.36589 7.31458 8.96589 7.55625 8.72422C7.79792 8.48255 8.19792 8.48255 8.43958 8.72422L10.1062 10.3909C10.3479 10.6326 10.3479 11.0326 10.1062 11.2742C9.98125 11.3992 9.82292 11.4576 9.66458 11.4576Z" fill="#64748B" />
                                                            <path d="M12.9974 18.9577H7.9974C3.4724 18.9577 1.53906 17.0243 1.53906 12.4993V7.49935C1.53906 2.97435 3.4724 1.04102 7.9974 1.04102H12.1641C12.5057 1.04102 12.7891 1.32435 12.7891 1.66602C12.7891 2.00768 12.5057 2.29102 12.1641 2.29102H7.9974C4.15573 2.29102 2.78906 3.65768 2.78906 7.49935V12.4993C2.78906 16.341 4.15573 17.7077 7.9974 17.7077H12.9974C16.8391 17.7077 18.2057 16.341 18.2057 12.4993V8.33268C18.2057 7.99102 18.4891 7.70768 18.8307 7.70768C19.1724 7.70768 19.4557 7.99102 19.4557 8.33268V12.4993C19.4557 17.0243 17.5224 18.9577 12.9974 18.9577Z" fill="#64748B" />
                                                            <path d="M18.8307 8.95841H15.4974C12.6474 8.95841 11.5391 7.85007 11.5391 5.00007V1.66674C11.5391 1.41674 11.6891 1.18341 11.9224 1.09174C12.1557 0.991739 12.4224 1.05007 12.6057 1.22507L19.2724 7.89174C19.4474 8.06674 19.5057 8.34174 19.4057 8.57507C19.3057 8.8084 19.0807 8.95841 18.8307 8.95841ZM12.7891 3.17507V5.00007C12.7891 7.15007 13.3474 7.70841 15.4974 7.70841H17.3224L12.7891 3.17507Z" fill="#64748B" />
                                                        </svg> File
                                                    </span>
                                                    <input type="file" name="upload" id="upload" class="upload-box" placeholder="Upload File" aria-label="Upload File">
                                                </a>                                            
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="audioControls">
                                        <button type="button" class="close-song" style="display: none;">✖</button>
        
                                        <button id="stopRecording" style="display: none;">Stop Recording</button>
                                        <button id="playRecording" style="display: none;">Play Recording</button>
                                        <button id="stopPlayback" style="display: none;">Stop Playback</button>
                                    </div>
        
        
                                    <div class="audio-container" id="audioContainer">
                                        <audio id="recordedAudio" class="recordedAudio" controls style="display: none;"></audio>
                                        <button class="close-audio-btn">X</button>
                                    </div>
                                    <span id="startRecording">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.5 15.5C14.71 15.5 16.5 13.71 16.5 11.5V6C16.5 3.79 14.71 2 12.5 2C10.29 2 8.5 3.79 8.5 6V11.5C8.5 13.71 10.29 15.5 12.5 15.5Z" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M4.85156 9.65039V11.3504C4.85156 15.5704 8.28156 19.0004 12.5016 19.0004C16.7216 19.0004 20.1516 15.5704 20.1516 11.3504V9.65039" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11.1094 6.42914C12.0094 6.09914 12.9894 6.09914 13.8894 6.42914" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11.7031 8.55031C12.2331 8.41031 12.7831 8.41031 13.3131 8.55031" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12.5 19V22" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="modal" id="msgBox">
    <div class="modal-dialog">
        <div class="modal-content position-relative">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">New Message</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div>
                   
                    <div class="d-flex align-items-center inbox">
                        <span>To:</span>
                        <div id="selected-tags-container">
                            <input type="text" id="search-user">
                        </div>
                        <input type="hidden" id="selected-user-id" name="selectedUserId" value="">
                    </div>
                   
                    <!-- =========== first-model =========== -->
                    <div class="empty-massage">
                        <div class="empty-img">
                            <img src="{{asset('assets/front')}}/image/empty-img.png" alt="empty-img">
                        </div>
                        <h5>Add Contact</h5>
                        <p>Please search and add contact to start new message</p>
                    </div>


                    <div class="chat-user d-none">
                        <div class="chat-user-img">
                            <img src="{{asset('assets/front')}}/image/user-img.svg" class="selected-user-img" alt="user-img">
                        </div>
                        <h4 class="selected-user-name">Tiana Dokidis</h4>
                        <a class="selected-user-email" href="mailto:tiana@gmail.com"><span>tiana@gmail.com</span></a>
                    </div>

                    <!-- ========= forth-modal ======== -->
                    <div class="multi-chat d-none">
                        <div class="img-wrp">
                        </div>
                        <h5 class="selected-user-name">Tiana Dokidis, Martin Garlic, +3</h5>
                        <p>This message will automatically create a group</p>
                        <a href="#">See all user</a><br>
                        <input type="text" id ="group-name" placeholder="Group Name">
                    </div>
                </div>
            </div>

            <div class="modal-footer">

                <div class="d-flex align-items-center">
                    <input type="text" placeholder="Write message here..." id="new_message">
                    <span class="ms-auto" id="send-new-msg">
                        <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5673 5.51062L7.00733 1.23062C1.25733 -1.64938 -1.10267 0.710623 1.77733 6.46062L2.64733 8.20062C2.89733 8.71062 2.89733 9.30062 2.64733 9.81062L1.77733 11.5406C-1.10267 17.2906 1.24733 19.6506 7.00733 16.7706L15.5673 12.4906C19.4073 10.5706 19.4073 7.43062 15.5673 5.51062ZM12.3373 9.75062H6.93733C6.52733 9.75062 6.18733 9.41062 6.18733 9.00062C6.18733 8.59062 6.52733 8.25062 6.93733 8.25062H12.3373C12.7473 8.25062 13.0873 8.59062 13.0873 9.00062C13.0873 9.41062 12.7473 9.75062 12.3373 9.75062Z" fill="#64748B" />
                        </svg>
                    </span>
                </div>

            </div>

        </div>
    </div>
</div>


<div class="modal" id="listBox">
    <div class="modal-dialog">
        <div class="modal-content position-relative">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="selected-title">Add New Message</h4>
                <div  class="change-group-name d-none">
                    <input type="text" class="update-group-name"/>
                    <button type="button" id="updateName">Save</button>
                </div>
                    <button type="button" class="btn-close close-group-modal" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-0">
                <div>
                    <div class="">
                        <input type="file" id="choose-file" name="choose-file" accept="image/*" />
                        <div class="position-relative">
                            <div class="cover-img user-cover-img" id="cover-img">
                                <img src="./assets/image/user-img.svg" alt="cover-img" id="profileIm">
                            </div>
                            <label class="choosen-file  edit-btn mb-0" for="choose-file">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.05 4.66652L4.20829 11.9082C3.94996 12.1832 3.69996 12.7249 3.64996 13.0999L3.34162 15.7999C3.23329 16.7749 3.93329 17.4415 4.89996 17.2749L7.58329 16.8165C7.95829 16.7499 8.48329 16.4749 8.74162 16.1915L15.5833 8.94985C16.7666 7.69985 17.3 6.27485 15.4583 4.53319C13.625 2.80819 12.2333 3.41652 11.05 4.66652Z"
                                        stroke="#0F172A" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9.9082 5.875C10.2665 8.175 12.1332 9.93333 14.4499 10.1667"
                                        stroke="#0F172A" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </label>
                        </div>
                    </div>
                    <div class="new-member d-none">
                        <button class="btn btn-primary" id="new-member"><span><i class="fa-solid fa-user-plus"></i></span> Add New Member</button>
                    </div>
                    <ul class="member-lists group-list">
                        <li class="">
                            <div class="chat-data d-flex">
                                <div class="user-img position-relative">
                                    <img class="img-fluid"
                                        src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                </div>
                                <div class="user-detail d-block ms-3">
                                    <div class="">
                                        <h3>Tiana Dokidis</h3>
                                        <a href="mailto:tiadokis@gmail.com"><span>tiadokis@gmail.com</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="">
                            <div class="chat-data d-flex">
                                <div class="user-img position-relative">
                                    <img class="img-fluid"
                                        src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                </div>
                                <div class="user-detail d-block ms-3">
                                    <div class="">
                                        <h3>Tiana Dokidis</h3>
                                        <a href="mailto:tiadokis@gmail.com"><span>tiadokis@gmail.com</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <div class="new-members-add d-none">

                        <div class="d-flex align-items-center inbox">
                        
                            <span>To:</span>
                            <div id="group-selected-tags-container">
                         
                                <input type="text" id="group-search-user">
                            </div>
                            <input type="hidden" id="group-selected-user-id" name="selectedUserId" value="">

                         
                            <button class="cmn-btn d-none" id="add-group-member">Add Member</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/timeago.js/4.0.2/timeago.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script type="module" src="{{asset('assets/front/js/message.js')}}"></script>
<script type="module" src="{{asset('assets/front/js/chat.js')}}"></script>
@endpush
