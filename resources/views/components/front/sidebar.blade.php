<div class="col-xxl-3 col-xl-4 col-lg-4 col-md-5 mb-md-0 mb-4">
    <div class="contact-user">
        <div class="user position-relative">

            @if($profileData->profile != "")
            <img src="{{$profileData->profile }}" alt="user-img" class="UserImg">
            @else

            @php $initials = strtoupper($profileData->firstname[0]) . strtoupper($profileData->lastname[0]);

            $fontColor = "fontcolor".strtoupper($profileData->firstname[0])
            @endphp

            <h5 class="{{ $fontColor }}"> {{ $initials }}</h5>
            @endif
            <div class="badge">
                <span class="active"></span>
            </div>
        </div>
        <div class="user-name">
            <div class="d-flex justify-content-center mb-2">
                <h3>{{$profileData->firstname.' '.$profileData->lastname }}</h3>

                @if($profileData->subscribe_status == false)
                {{-- <span class="free">Free</span> --}}
                @else
                <span>Pro Year</span>
                @endif
            </div>
            <p>Member Since: {{ $profileData->join_date }}</p>
        </div>
        <div class="user-location {{ ($profileData->city == NULL)?'remove-border':''}}">
            <div>
                <span>
                    <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.20898 12.0106H3.79232C1.81523 12.0106 0.677734 10.8731 0.677734 8.896V5.10433C0.677734 3.12725 1.81523 1.98975 3.79232 1.98975H9.20898C11.1861 1.98975 12.3236 3.12725 12.3236 5.10433V8.896C12.3236 10.8731 11.1861 12.0106 9.20898 12.0106ZM3.79232 2.80225C2.24315 2.80225 1.49023 3.55516 1.49023 5.10433V8.896C1.49023 10.4452 2.24315 11.1981 3.79232 11.1981H9.20898C10.7582 11.1981 11.5111 10.4452 11.5111 8.896V5.10433C11.5111 3.55516 10.7582 2.80225 9.20898 2.80225H3.79232Z" fill="#64748B" />
                        <path d="M6.50082 7.47148C6.04582 7.47148 5.5854 7.33065 5.23332 7.04356L3.5379 5.6894C3.36456 5.54856 3.33207 5.29398 3.4729 5.12064C3.61373 4.94731 3.86832 4.91481 4.04165 5.05565L5.73706 6.40981C6.14873 6.74023 6.84748 6.74023 7.25915 6.40981L8.95457 5.05565C9.1279 4.91481 9.3879 4.94189 9.52332 5.12064C9.66415 5.29398 9.63707 5.55398 9.45832 5.6894L7.7629 7.04356C7.41623 7.33065 6.95582 7.47148 6.50082 7.47148Z" fill="#64748B" />
                    </svg>
                </span>
                <a href="mailto:{{$profileData->email }}">{{$profileData->email }}</a>
            </div>
            @if($profileData->city != NULL)
            <div>
                <span>
                    <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.98893 6.86475H5.00977C4.78768 6.86475 4.60352 6.68058 4.60352 6.4585C4.60352 6.23641 4.78768 6.05225 5.00977 6.05225H7.98893C8.21102 6.05225 8.39518 6.23641 8.39518 6.4585C8.39518 6.68058 8.21102 6.86475 7.98893 6.86475Z" fill="#64748B" />
                        <path d="M6.50089 12.8285C5.69922 12.8285 4.89214 12.5252 4.26381 11.9239C2.66589 10.3856 0.900056 7.93183 1.56631 5.01225C2.16756 2.3635 4.48047 1.17725 6.50089 1.17725C6.50089 1.17725 6.50089 1.17725 6.50631 1.17725C8.52672 1.17725 10.8396 2.3635 11.4409 5.01766C12.1017 7.93725 10.3359 10.3856 8.73797 11.9239C8.10964 12.5252 7.30256 12.8285 6.50089 12.8285ZM6.50089 1.98975C4.92464 1.98975 2.89881 2.82933 2.36256 5.191C1.77756 7.74225 3.38089 9.94141 4.83256 11.3335C5.76964 12.2381 7.23756 12.2381 8.17464 11.3335C9.62089 9.94141 11.2242 7.74225 10.6501 5.191C10.1084 2.82933 8.07714 1.98975 6.50089 1.98975Z" fill="#64748B" />
                    </svg>
                </span>
                <span>{{$profileData->city.','.$profileData->state}}</span>
            </div>
            @endif
        </div>
        <!-- <a href="#" class="switch-ac" data-bs-toggle="modal" data-bs-target="#manageModel">
            <span>Manage | Switch Accounts</span>
        </a> -->



        <div class="user-gallery">
            <div>
                <h4>{{formatNumber($profileData->event_count)}}</h4>
                <p>Events</p>
            </div>
            <div>
                <h4>{{formatNumber($profileData->event_post_count)}}</h4>
                <p>Photos</p>
            </div>
            <div>
                <h4>{{formatNumber($profileData->event_post_comment_count)}}</h4>
                <p>Comments</p>
            </div>
        </div>
        <ul class="user-account">
            <li>
                <a href="{{route('profile')}}" class="d-flex align-items-center {{ (Request::segment(1) == 'profile')? 'active':'' }}">
                    <span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.99992 10.625C7.35825 10.625 5.20825 8.47502 5.20825 5.83335C5.20825 3.19169 7.35825 1.04169 9.99992 1.04169C12.6416 1.04169 14.7916 3.19169 14.7916 5.83335C14.7916 8.47502 12.6416 10.625 9.99992 10.625ZM9.99992 2.29169C8.04992 2.29169 6.45825 3.88335 6.45825 5.83335C6.45825 7.78335 8.04992 9.37502 9.99992 9.37502C11.9499 9.37502 13.5416 7.78335 13.5416 5.83335C13.5416 3.88335 11.9499 2.29169 9.99992 2.29169Z" fill="#64748B" />
                            <path d="M17.1585 18.9583C16.8168 18.9583 16.5335 18.675 16.5335 18.3333C16.5335 15.4583 13.6001 13.125 10.0001 13.125C6.40013 13.125 3.4668 15.4583 3.4668 18.3333C3.4668 18.675 3.18346 18.9583 2.8418 18.9583C2.50013 18.9583 2.2168 18.675 2.2168 18.3333C2.2168 14.775 5.70846 11.875 10.0001 11.875C14.2918 11.875 17.7835 14.775 17.7835 18.3333C17.7835 18.675 17.5001 18.9583 17.1585 18.9583Z" fill="#64748B" />
                        </svg>
                    </span>
                    <h5>Profile</h5>
                </a>
            </li>
            <li>
                <a href="#" class="d-flex align-items-center">
                    <span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.66602 4.7915C6.32435 4.7915 6.04102 4.50817 6.04102 4.1665V1.6665C6.04102 1.32484 6.32435 1.0415 6.66602 1.0415C7.00768 1.0415 7.29102 1.32484 7.29102 1.6665V4.1665C7.29102 4.50817 7.00768 4.7915 6.66602 4.7915Z" fill="#64748B" />
                            <path d="M13.334 4.7915C12.9923 4.7915 12.709 4.50817 12.709 4.1665V1.6665C12.709 1.32484 12.9923 1.0415 13.334 1.0415C13.6757 1.0415 13.959 1.32484 13.959 1.6665V4.1665C13.959 4.50817 13.6757 4.7915 13.334 4.7915Z" fill="#64748B" />
                            <path d="M7.08333 12.0834C6.975 12.0834 6.86666 12.0584 6.76666 12.0168C6.65833 11.9751 6.57501 11.9167 6.49167 11.8417C6.34167 11.6834 6.25 11.4667 6.25 11.2501C6.25 11.0334 6.34167 10.8167 6.49167 10.6584C6.57501 10.5834 6.66666 10.5251 6.76666 10.4834C6.96666 10.4001 7.2 10.4001 7.4 10.4834C7.5 10.5251 7.59166 10.5834 7.67499 10.6584C7.70833 10.7001 7.74999 10.7417 7.77499 10.7834C7.80832 10.8334 7.83334 10.8834 7.85001 10.9334C7.87501 10.9834 7.89168 11.0334 7.90001 11.0834C7.90834 11.1417 7.91667 11.2001 7.91667 11.2501C7.91667 11.4667 7.82499 11.6834 7.67499 11.8417C7.59166 11.9167 7.5 11.9751 7.4 12.0168C7.3 12.0584 7.19167 12.0834 7.08333 12.0834Z" fill="#64748B" />
                            <path d="M9.99935 12.0835C9.89102 12.0835 9.78268 12.0585 9.68268 12.0168C9.57434 11.9752 9.49102 11.9168 9.40769 11.8418C9.25769 11.6835 9.16602 11.4668 9.16602 11.2502C9.16602 11.2002 9.17434 11.1418 9.18267 11.0835C9.19101 11.0335 9.20767 10.9835 9.23267 10.9335C9.24934 10.8835 9.27436 10.8335 9.30769 10.7835C9.34103 10.7418 9.37436 10.7002 9.40769 10.6585C9.71602 10.3502 10.2743 10.3502 10.591 10.6585C10.6243 10.7002 10.6577 10.7418 10.691 10.7835C10.7243 10.8335 10.7494 10.8835 10.766 10.9335C10.791 10.9835 10.8077 11.0335 10.816 11.0835C10.8244 11.1418 10.8327 11.2002 10.8327 11.2502C10.8327 11.4668 10.741 11.6835 10.591 11.8418C10.4327 11.9918 10.2243 12.0835 9.99935 12.0835Z" fill="#64748B" />
                            <path d="M7.08333 14.9999C6.975 14.9999 6.86666 14.9749 6.76666 14.9333C6.66666 14.8916 6.57501 14.8332 6.49167 14.7582C6.34167 14.5999 6.25 14.3832 6.25 14.1666C6.25 14.1166 6.25832 14.0582 6.26666 14.0082C6.27499 13.9499 6.29166 13.8999 6.31666 13.8499C6.33332 13.7999 6.35834 13.7499 6.39168 13.6999C6.41668 13.6582 6.45834 13.6166 6.49167 13.5749C6.57501 13.4999 6.66666 13.4416 6.76666 13.3999C6.96666 13.3166 7.2 13.3166 7.4 13.3999C7.5 13.4416 7.59166 13.4999 7.67499 13.5749C7.70833 13.6166 7.74999 13.6582 7.77499 13.6999C7.80832 13.7499 7.83334 13.7999 7.85001 13.8499C7.87501 13.8999 7.89168 13.9499 7.90001 14.0082C7.90834 14.0582 7.91667 14.1166 7.91667 14.1666C7.91667 14.3832 7.82499 14.5999 7.67499 14.7582C7.59166 14.8332 7.5 14.8916 7.4 14.9333C7.3 14.9749 7.19167 14.9999 7.08333 14.9999Z" fill="#64748B" />
                            <path d="M17.0827 8.20019H2.91602C2.57435 8.20019 2.29102 7.91686 2.29102 7.5752C2.29102 7.23353 2.57435 6.9502 2.91602 6.9502H17.0827C17.4243 6.9502 17.7077 7.23353 17.7077 7.5752C17.7077 7.91686 17.4243 8.20019 17.0827 8.20019Z" fill="#64748B" />
                            <path d="M13.1843 18.9833C12.8676 18.9833 12.5676 18.8667 12.3509 18.65C12.0926 18.3917 11.9759 18.0167 12.0343 17.625L12.1926 16.5C12.2343 16.2083 12.4093 15.8583 12.6176 15.65L15.5676 12.7C15.9676 12.3 16.3593 12.0917 16.7843 12.05C17.3093 12 17.8176 12.2167 18.3009 12.7C18.8093 13.2083 19.4926 14.2417 18.3009 15.4333L15.3509 18.3833C15.1426 18.5917 14.7926 18.7667 14.5009 18.8083L13.3759 18.9667C13.3093 18.975 13.2509 18.9833 13.1843 18.9833ZM16.9259 13.2917C16.9176 13.2917 16.9093 13.2917 16.9009 13.2917C16.7843 13.3 16.6259 13.4083 16.4509 13.5833L13.5009 16.5333C13.4759 16.5583 13.4343 16.6417 13.4343 16.675L13.2843 17.7167L14.3259 17.5667C14.3593 17.5583 14.4426 17.5167 14.4676 17.4917L17.4176 14.5417C17.7843 14.175 17.8343 13.9917 17.4176 13.575C17.2843 13.45 17.0926 13.2917 16.9259 13.2917Z" fill="#64748B" />
                            <path d="M17.4338 16.0418C17.3755 16.0418 17.3171 16.0334 17.2671 16.0168C16.1671 15.7084 15.2922 14.8334 14.9838 13.7334C14.8922 13.4001 15.0838 13.0584 15.4171 12.9584C15.7505 12.8668 16.0921 13.0584 16.1921 13.3918C16.3838 14.0751 16.9255 14.6168 17.6088 14.8084C17.9421 14.9001 18.1338 15.2501 18.0421 15.5834C17.9588 15.8584 17.7088 16.0418 17.4338 16.0418Z" fill="#64748B" />
                            <path d="M10 18.9582H6.66667C3.625 18.9582 1.875 17.2082 1.875 14.1665V7.08317C1.875 4.0415 3.625 2.2915 6.66667 2.2915H13.3333C16.375 2.2915 18.125 4.0415 18.125 7.08317V9.99984C18.125 10.3415 17.8417 10.6248 17.5 10.6248C17.1583 10.6248 16.875 10.3415 16.875 9.99984V7.08317C16.875 4.69984 15.7167 3.5415 13.3333 3.5415H6.66667C4.28333 3.5415 3.125 4.69984 3.125 7.08317V14.1665C3.125 16.5498 4.28333 17.7082 6.66667 17.7082H10C10.3417 17.7082 10.625 17.9915 10.625 18.3332C10.625 18.6748 10.3417 18.9582 10 18.9582Z" fill="#64748B" />
                        </svg>
                    </span>
                    <h5>Event Drafts</h5>
                </a>
            </li>
            <li>
                <a href="{{route('profile.contact')}}" class="d-flex align-items-center {{ (Request::segment(1) == 'contact')? 'active':'' }}">
                    <span>
                        <svg width="20" height="20" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.5417 17.9584C12.6001 17.9584 11.6084 17.7334 10.5834 17.3C9.58341 16.875 8.57508 16.2917 7.59175 15.5834C6.61675 14.8667 5.67508 14.0667 4.78341 13.1917C3.90008 12.3 3.10008 11.3584 2.39175 10.3917C1.67508 9.39169 1.10008 8.39169 0.691748 7.42502C0.258415 6.39169 0.041748 5.39169 0.041748 4.45002C0.041748 3.80002 0.158415 3.18335 0.383415 2.60835C0.616748 2.01669 0.991748 1.46669 1.50008 0.991687C2.14175 0.358354 2.87508 0.041687 3.65842 0.041687C3.98342 0.041687 4.31675 0.116687 4.60008 0.25002C4.92508 0.40002 5.20008 0.62502 5.40008 0.92502L7.33342 3.65002C7.50842 3.89169 7.64175 4.12502 7.73341 4.35835C7.84175 4.60835 7.90008 4.85835 7.90008 5.10002C7.90008 5.41669 7.80841 5.72502 7.63341 6.01669C7.50841 6.24169 7.31675 6.48335 7.07508 6.72502L6.50842 7.31669C6.51675 7.34169 6.52508 7.35835 6.53341 7.37502C6.63341 7.55002 6.83341 7.85002 7.21675 8.30002C7.62508 8.76669 8.00842 9.19169 8.39175 9.58335C8.88342 10.0667 9.29175 10.45 9.67508 10.7667C10.1501 11.1667 10.4584 11.3667 10.6417 11.4584L10.6251 11.5L11.2334 10.9C11.4917 10.6417 11.7417 10.45 11.9834 10.325C12.4417 10.0417 13.0251 9.99169 13.6084 10.2334C13.8251 10.325 14.0584 10.45 14.3084 10.625L17.0751 12.5917C17.3834 12.8 17.6084 13.0667 17.7417 13.3834C17.8667 13.7 17.9251 13.9917 17.9251 14.2834C17.9251 14.6834 17.8334 15.0834 17.6584 15.4584C17.4834 15.8334 17.2667 16.1584 16.9917 16.4584C16.5167 16.9834 16.0001 17.3584 15.4001 17.6C14.8251 17.8334 14.2001 17.9584 13.5417 17.9584ZM3.65842 1.29169C3.20008 1.29169 2.77508 1.49169 2.36675 1.89169C1.98341 2.25002 1.71675 2.64169 1.55008 3.06669C1.37508 3.50002 1.29175 3.95835 1.29175 4.45002C1.29175 5.22502 1.47508 6.06669 1.84175 6.93335C2.21675 7.81669 2.74175 8.73335 3.40841 9.65002C4.07508 10.5667 4.83341 11.4584 5.66675 12.3C6.50008 13.125 7.40008 13.8917 8.32508 14.5667C9.22508 15.225 10.1501 15.7584 11.0667 16.1417C12.4917 16.75 13.8251 16.8917 14.9251 16.4334C15.3501 16.2584 15.7251 15.9917 16.0667 15.6084C16.2584 15.4 16.4084 15.175 16.5334 14.9084C16.6334 14.7 16.6834 14.4834 16.6834 14.2667C16.6834 14.1334 16.6584 14 16.5917 13.85C16.5667 13.8 16.5167 13.7084 16.3584 13.6L13.5917 11.6334C13.4251 11.5167 13.2751 11.4334 13.1334 11.375C12.9501 11.3 12.8751 11.225 12.5917 11.4C12.4251 11.4834 12.2751 11.6084 12.1084 11.775L11.4751 12.4C11.1501 12.7167 10.6501 12.7917 10.2667 12.65L10.0417 12.55C9.70008 12.3667 9.30008 12.0834 8.85842 11.7084C8.45842 11.3667 8.02508 10.9667 7.50008 10.45C7.09175 10.0334 6.68342 9.59169 6.25842 9.10002C5.86675 8.64169 5.58342 8.25002 5.40842 7.92502L5.30842 7.67502C5.25842 7.48335 5.24175 7.37502 5.24175 7.25835C5.24175 6.95835 5.35008 6.69169 5.55841 6.48335L6.18341 5.83335C6.35008 5.66669 6.47508 5.50835 6.55841 5.36669C6.62508 5.25835 6.65008 5.16669 6.65008 5.08335C6.65008 5.01669 6.62508 4.91669 6.58342 4.81669C6.52508 4.68335 6.43341 4.53335 6.31675 4.37502L4.38341 1.64169C4.30008 1.52502 4.20008 1.44169 4.07508 1.38335C3.94175 1.32502 3.80008 1.29169 3.65842 1.29169ZM10.6251 11.5084L10.4917 12.075L10.7167 11.4917C10.6751 11.4834 10.6417 11.4917 10.6251 11.5084Z" fill="#64748B" />
                        </svg>
                    </span>
                    <h5>Contacts</h5>
                </a>
            </li>
            <li>
                <a href="{{route('profile.account_settings')}}" class="d-flex align-items-center {{ (Request::segment(1) == 'account_settings')? 'active':'' }}">
                    <span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 13.125C8.275 13.125 6.875 11.725 6.875 10C6.875 8.275 8.275 6.875 10 6.875C11.725 6.875 13.125 8.275 13.125 10C13.125 11.725 11.725 13.125 10 13.125ZM10 8.125C8.96667 8.125 8.125 8.96667 8.125 10C8.125 11.0333 8.96667 11.875 10 11.875C11.0333 11.875 11.875 11.0333 11.875 10C11.875 8.96667 11.0333 8.125 10 8.125Z" fill="#64748B" />
                            <path d="M12.6751 18.4917C12.5001 18.4917 12.3251 18.4667 12.1501 18.425C11.6334 18.2833 11.2001 17.9583 10.9251 17.5L10.8251 17.3333C10.3334 16.4833 9.65842 16.4833 9.16675 17.3333L9.07508 17.4917C8.80008 17.9583 8.36675 18.2917 7.85008 18.425C7.32508 18.5667 6.78342 18.4917 6.32508 18.2167L4.89175 17.3917C4.38341 17.1 4.01675 16.625 3.85841 16.05C3.70841 15.475 3.78341 14.8833 4.07508 14.375C4.31675 13.95 4.38342 13.5667 4.24175 13.325C4.10008 13.0833 3.74175 12.9417 3.25008 12.9417C2.03341 12.9417 1.04175 11.95 1.04175 10.7333V9.26668C1.04175 8.05001 2.03341 7.05835 3.25008 7.05835C3.74175 7.05835 4.10008 6.91668 4.24175 6.67502C4.38342 6.43335 4.32508 6.05002 4.07508 5.62502C3.78341 5.11668 3.70841 4.51668 3.85841 3.95001C4.00841 3.37501 4.37508 2.90001 4.89175 2.60835L6.33341 1.78335C7.27508 1.22501 8.51675 1.55001 9.08341 2.50835L9.18342 2.67501C9.67508 3.52501 10.3501 3.52501 10.8417 2.67501L10.9334 2.51668C11.5001 1.55001 12.7417 1.22501 13.6917 1.79168L15.1251 2.61668C15.6334 2.90835 16.0001 3.38335 16.1584 3.95835C16.3084 4.53335 16.2334 5.12502 15.9417 5.63335C15.7001 6.05835 15.6334 6.44168 15.7751 6.68335C15.9167 6.92502 16.2751 7.06668 16.7667 7.06668C17.9834 7.06668 18.9751 8.05835 18.9751 9.27502V10.7417C18.9751 11.9583 17.9834 12.95 16.7667 12.95C16.2751 12.95 15.9167 13.0917 15.7751 13.3333C15.6334 13.575 15.6917 13.9583 15.9417 14.3833C16.2334 14.8917 16.3167 15.4917 16.1584 16.0583C16.0084 16.6333 15.6417 17.1083 15.1251 17.4L13.6834 18.225C13.3667 18.4 13.0251 18.4917 12.6751 18.4917ZM10.0001 15.4083C10.7417 15.4083 11.4334 15.875 11.9084 16.7L12.0001 16.8583C12.1001 17.0333 12.2667 17.1583 12.4667 17.2083C12.6667 17.2583 12.8667 17.2333 13.0334 17.1333L14.4751 16.3C14.6917 16.175 14.8584 15.9667 14.9251 15.7167C14.9917 15.4667 14.9584 15.2083 14.8334 14.9917C14.3584 14.175 14.3001 13.3333 14.6667 12.6917C15.0334 12.05 15.7917 11.6833 16.7417 11.6833C17.2751 11.6833 17.7001 11.2583 17.7001 10.725V9.25835C17.7001 8.73335 17.2751 8.30001 16.7417 8.30001C15.7917 8.30001 15.0334 7.93335 14.6667 7.29168C14.3001 6.65002 14.3584 5.80835 14.8334 4.99168C14.9584 4.77501 14.9917 4.51668 14.9251 4.26668C14.8584 4.01668 14.7001 3.81668 14.4834 3.68335L13.0417 2.85835C12.6834 2.64168 12.2084 2.76668 11.9917 3.13335L11.9001 3.29168C11.4251 4.11668 10.7334 4.58335 9.99175 4.58335C9.25008 4.58335 8.55841 4.11668 8.08341 3.29168L7.99175 3.12501C7.78342 2.77501 7.31675 2.65001 6.95842 2.85835L5.51675 3.69168C5.30008 3.81668 5.13341 4.02502 5.06675 4.27502C5.00008 4.52502 5.03341 4.78335 5.15841 5.00002C5.63341 5.81668 5.69175 6.65835 5.32508 7.30002C4.95841 7.94168 4.20008 8.30835 3.25008 8.30835C2.71675 8.30835 2.29175 8.73335 2.29175 9.26668V10.7333C2.29175 11.2583 2.71675 11.6917 3.25008 11.6917C4.20008 11.6917 4.95841 12.0583 5.32508 12.7C5.69175 13.3417 5.63341 14.1833 5.15841 15C5.03341 15.2167 5.00008 15.475 5.06675 15.725C5.13341 15.975 5.29175 16.175 5.50842 16.3083L6.95008 17.1333C7.12508 17.2417 7.33341 17.2667 7.52508 17.2167C7.72508 17.1667 7.89175 17.0333 8.00008 16.8583L8.09175 16.7C8.56675 15.8833 9.25842 15.4083 10.0001 15.4083Z" fill="#64748B" />
                        </svg>
                    </span>
                    <h5>Account Settings</h5>
                </a>
            </li>
        </ul>
        <div class="d-flex align-items-center">

            <a href="#" type="button" class="support-btn">
                <svg class="me-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.334 12.2868H8.66732L5.70064 14.2601C5.26064 14.5535 4.66732 14.2402 4.66732 13.7068V12.2868C2.66732 12.2868 1.33398 10.9535 1.33398 8.95349V4.95345C1.33398 2.95345 2.66732 1.62012 4.66732 1.62012H11.334C13.334 1.62012 14.6673 2.95345 14.6673 4.95345V8.95349C14.6673 10.9535 13.334 12.2868 11.334 12.2868Z" stroke="#0F172A" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.99923 7.57324V7.43327C7.99923 6.97993 8.27924 6.73992 8.55924 6.54659C8.83258 6.35992 9.10588 6.11993 9.10588 5.67993C9.10588 5.0666 8.61256 4.57324 7.99923 4.57324C7.38589 4.57324 6.89258 5.0666 6.89258 5.67993" stroke="#0F172A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.99635 9.16683H8.00235" stroke="#0F172A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Support
            </a>

            <a href="{{route('logout')}}" type="button" class="Logout-btn">
                <svg class="me-1" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.91675 6.30001C8.17508 3.30001 9.71675 2.07501 13.0917 2.07501H13.2001C16.9251 2.07501 18.4167 3.56668 18.4167 7.29168V12.725C18.4167 16.45 16.9251 17.9417 13.2001 17.9417H13.0917C9.74175 17.9417 8.20008 16.7333 7.92508 13.7833" stroke="#0F172A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2.16675 10H12.9001" stroke="#0F172A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M11.0417 7.20831L13.8334 9.99998L11.0417 12.7916" stroke="#0F172A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Logout
            </a>

        </div>
    </div>
</div>

<div class="modal fade" id="manageModel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header align-items-start">
                <div>
                    <h4 class="modal-title">Manage Accounts</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="manage-account">
                    <div class="users-data">
                        <div class="d-flex align-items-start">
                            <div class="contact-img">


                                @if($profileData->profile != "")
                                <img src="{{$profileData->profile }}" alt="user-img" class="UserImg">
                                @else

                                @php $initials = strtoupper($profileData->firstname[0]) . strtoupper($profileData->lastname[0]);

                                $fontColor = "fontcolor".strtoupper($profileData->firstname[0])
                                @endphp

                                <h5 class="{{ $fontColor }}"> {{ $initials }}</h5>
                                @endif

                            </div>
                            <div class="text-start">
                                <h5>{{$profileData->firstname.' '.$profileData->lastname}}</h5>
                                <div>
                                    <a href="mailto:{{$profileData->email}}">{{$profileData->email}}</a>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('profile.account_settings')}}" class="edit-contact">Account Settings</a>
                    </div>
                    @if(Session::has('secondary_user'))
                    <a href="{{route('switchAccount',Session::get('secondary_user')['id'])}}" class="users-data">
                        <div class="d-flex align-items-start">
                            <div class="contact-img">


                                @if(Session::get('secondary_user')['secondary_profile'] != "")
                                <img src="{{ Session::get('secondary_user')['secondary_profile'] }}" alt="user-img" class="UserImg">
                                @else
                                @php

                                $initials = strtoupper(Session::get('secondary_user')['first_name'][0]) . strtoupper(Session::get('secondary_user')['last_name'][0]);

                                $fontColor = "fontcolor".strtoupper(Session::get('secondary_user')['first_name'][0])
                                @endphp

                                <h5 class="{{ $fontColor }}"> {{ $initials }}</h5>
                                @endif


                            </div>
                            <div class="text-start">
                                <h5>{{Session::get('secondary_user')['secondary_username']}}</h5>
                                <div>
                                    <p>{{Session::get('secondary_user')['secondary_email']}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <span class="ms-auto">
                            <svg class="ms-auto" width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.940228 11.78C0.813561 11.78 0.686895 11.7333 0.586895 11.6333C0.393561 11.44 0.393561 11.12 0.586895 10.9267L4.93356 6.58001C5.25356 6.26001 5.25356 5.74001 4.93356 5.42001L0.586895 1.07335C0.393561 0.880013 0.393561 0.560013 0.586895 0.36668C0.780228 0.173346 1.10023 0.173346 1.29356 0.36668L5.64023 4.71335C5.98023 5.05335 6.17356 5.51335 6.17356 6.00001C6.17356 6.48668 5.98689 6.94668 5.64023 7.28668L1.29356 11.6333C1.19356 11.7267 1.06689 11.78 0.940228 11.78Z" fill="#94A3B8" />
                            </svg>
                        </span>
                    </a>
                    @endif
                </div>
                <div class="text-end mt-2">
                    <a href="{{route('auth.add_account')}}" class="cmn-btn"><svg class="me-1" width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5026 0.833984V10.1673M0.835938 5.50065H10.1693" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Add Account</a>
                </div>
            </div>
        </div>
    </div>
</div>