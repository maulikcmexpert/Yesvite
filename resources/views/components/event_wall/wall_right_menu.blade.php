{{-- {{dd($eventDetails)}} --}}
<div class="main-content-right">
    <div class="main-right-guests-wrp common-div-wrp">
        <div class="main-right-guests-head">
            <h3>Guests</h3>
            <p>20 Active</p>
        </div>
        @php
            // Safely fetch the value of 'event_detail[2]' or set it to null if it doesn't exist
$guestString = $eventDetails['event_detail'][2] ?? null;

if ($guestString !== null) {
    $guestJson = trim(str_replace('guests : ', '', $guestString));

    $guests = json_decode($guestJson, true);
} else {
    $guests = [];
}

// Sample guests array from the provided data
$hostView = $eventInfo['host_view'];

// Initialize totals
$totalAdults = 0;
$totalKids = 0;

// Sum up adults and kids
if ($hostView) {
    $totalAdults += $hostView['adults'] ?? 0;
    $totalKids += $hostView['kids'] ?? 0;
            }

            // Total attending
            $totalAttending = $totalAdults + $totalKids;
        @endphp

        <div class="guest-attending-wrp">
            <div class="total-attending-guest">
                <h4>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.5013 1.66669C5.31797 1.66669 3.54297 3.44169 3.54297 5.62502C3.54297 7.76669 5.21797 9.50002 7.4013 9.57502C7.46797 9.56669 7.53464 9.56669 7.58464 9.57502C7.6013 9.57502 7.60963 9.57502 7.6263 9.57502C7.63463 9.57502 7.63463 9.57502 7.64297 9.57502C9.7763 9.50002 11.4513 7.76669 11.4596 5.62502C11.4596 3.44169 9.68463 1.66669 7.5013 1.66669Z"
                            fill="#0DAD5F" />
                        <path
                            d="M11.7328 11.7917C9.40781 10.2417 5.61615 10.2417 3.27448 11.7917C2.21615 12.5 1.63281 13.4583 1.63281 14.4833C1.63281 15.5083 2.21615 16.4583 3.26615 17.1583C4.43281 17.9417 5.96615 18.3333 7.49948 18.3333C9.03281 18.3333 10.5661 17.9417 11.7328 17.1583C12.7828 16.45 13.3661 15.5 13.3661 14.4667C13.3578 13.4417 12.7828 12.4917 11.7328 11.7917Z"
                            fill="#0DAD5F" />
                        <path
                            d="M16.6578 6.11665C16.7911 7.73331 15.6411 9.14998 14.0495 9.34165C14.0411 9.34165 14.0411 9.34165 14.0328 9.34165H14.0078C13.9578 9.34165 13.9078 9.34165 13.8661 9.35831C13.0578 9.39998 12.3161 9.14165 11.7578 8.66665C12.6161 7.89998 13.1078 6.74998 13.0078 5.49998C12.9495 4.82498 12.7161 4.20831 12.3661 3.68331C12.6828 3.52498 13.0495 3.42498 13.4245 3.39165C15.0578 3.24998 16.5161 4.46665 16.6578 6.11665Z"
                            fill="#0DAD5F" />
                        <path
                            d="M18.3268 13.825C18.2602 14.6334 17.7435 15.3334 16.8768 15.8084C16.0435 16.2667 14.9935 16.4834 13.9518 16.4584C14.5518 15.9167 14.9018 15.2417 14.9685 14.525C15.0518 13.4917 14.5602 12.5 13.5768 11.7084C13.0185 11.2667 12.3685 10.9167 11.6602 10.6584C13.5018 10.125 15.8185 10.4834 17.2435 11.6334C18.0102 12.25 18.4018 13.025 18.3268 13.825Z"
                            fill="#0DAD5F" />
                    </svg>
                    {{ $totalAttending }} <span> Attending</span>
                </h4>
            </div>
            <div class="type-guset-wrp">
                <h4>{{ $totalAdults }} <span>Adults</span></h4>
                <h4>{{ $totalKids }} <span>Kids</span></h4>
            </div>
        </div>
        <div class="all-events-searchbar-wrp">
            <form>
                <div class="position-relative">
                    <input type="text" class="form-control" id="text" placeholder="Search name">
                    <span class="search-icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.58268 17.5C13.9549 17.5 17.4993 13.9555 17.4993 9.58329C17.4993 5.21104 13.9549 1.66663 9.58268 1.66663C5.21043 1.66663 1.66602 5.21104 1.66602 9.58329C1.66602 13.9555 5.21043 17.5 9.58268 17.5Z"
                                stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.3327 18.3333L16.666 16.6666" stroke="#94A3B8" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </form>
        </div>
        <div class="guests-listing-wrp">
            <ul>
                @foreach ($guests as $guest)
                    @if (isset($guest['user']))
                        @php
                            $user = $guest['user']; // Fetch user array
                            //   dd($guest['user'])
                        @endphp
                        <li class="guests-listing-info">
                            <div class="posts-card-head-left guests-listing-left">
                                <div class="posts-card-head-left-img">
                                    <img src="{{ asset('storage/profile/' . $user['profile']) }} " alt="">
                                    <span class="active-dot"></span>
                                </div>
                                <div class="posts-card-head-left-content">
                                    <h3>{{ $user['firstname'] }} {{ $user['lastname'] }}</h3>
                                    <p>{{ $user['city'] }},{{ $user['state'] }}</p>
                                </div>
                            </div>
                            <div class="guests-listing-right">
                                @if ($guest['rsvp_status'] == '1')
                                    <!-- Approved -->
                                    <span id="approve">
                                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.0013 18.4583C5.33578 18.4583 1.54297 14.6655 1.54297 9.99996C1.54297 5.33444 5.33578 1.54163 10.0013 1.54163C14.6668 1.54163 18.4596 5.33444 18.4596 9.99996C18.4596 14.6655 14.6668 18.4583 10.0013 18.4583ZM10.0013 1.79163C5.47516 1.79163 1.79297 5.47382 1.79297 9.99996C1.79297 14.5261 5.47516 18.2083 10.0013 18.2083C14.5274 18.2083 18.2096 14.5261 18.2096 9.99996C18.2096 5.47382 14.5274 1.79163 10.0013 1.79163Z"
                                                fill="#23AA26" stroke="#23AA26" />
                                            <path
                                                d="M8.46363 11.8285L8.81719 12.1821L9.17074 11.8285L13.4541 7.54518C13.4756 7.52365 13.5063 7.51038 13.5422 7.51038C13.578 7.51038 13.6088 7.52365 13.6303 7.54518C13.6518 7.56671 13.6651 7.59744 13.6651 7.63329C13.6651 7.66914 13.6518 7.69988 13.6303 7.72141L8.9053 12.4464C8.88133 12.4704 8.84974 12.4833 8.81719 12.4833C8.78464 12.4833 8.75304 12.4704 8.72907 12.4464L6.37074 10.0881C6.34921 10.0665 6.33594 10.0358 6.33594 9.99996C6.33594 9.96411 6.34921 9.93337 6.37074 9.91185C6.39227 9.89032 6.423 9.87704 6.45885 9.87704C6.49471 9.87704 6.52544 9.89032 6.54697 9.91185L8.46363 11.8285Z"
                                                fill="#23AA26" stroke="#23AA26" />
                                        </svg>
                                    </span>
                                @elseif ($guest['rsvp_status'] == '0')
                                    <!-- Cancelled -->
                                    <span id="cancel">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect width="20" height="20" rx="10" fill="#E03137" />
                                            <path d="M5.91797 5.91663L14.0841 14.0827" stroke="white"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.91787 14.0827L14.084 5.91663" stroke="white"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                @else
                                    <!-- Pending -->
                                    <span id="pending">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect width="20" height="20" rx="10" fill="#94A3B8" />
                                            <path
                                                d="M15.8327 10C15.8327 13.22 13.2193 15.8334 9.99935 15.8334C6.77935 15.8334 4.16602 13.22 4.16602 10C4.16602 6.78002 6.77935 4.16669 9.99935 4.16669C13.2193 4.16669 15.8327 6.78002 15.8327 10Z"
                                                stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M12.1632 11.855L10.3549 10.7759C10.0399 10.5892 9.7832 10.14 9.7832 9.77253V7.38086"
                                                stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                @endif
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editrsvp"><i
                                        class="fa-solid fa-ellipsis-vertical"></i></button>
                            </div>
                        </li>
                    @endif
                @endforeach



            </ul>
            <div class="guests-listing-buttons">
                <a href="" class="cmn-btn see-all-btn">See All</a>
                <button class="cmn-btn" type="button" data-bs-toggle="modal" data-bs-target="#addguest"><i
                        class="fa-solid fa-plus"></i> Add Guest</button>
            </div>
        </div>
    </div>

</div>
{{-- <div class="modal fade cmn-modal" id="editrsvp" tabindex="-1" aria-labelledby="editrsvpLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editrsvpLabel">Edit RSVP Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="guest-rsvp-head">
                    <div class="rsvp-img">
                        <img src="{{ asset('assets/front/img/rs-img.png') }}')}}" alt="rs-img">
                    </div>
                    <h5>Tiana Dokidis</h5>
                </div>
                <div class="guest-rsvp-incres">
                    <h6>Guests</h6>
                    <div class="guest-edit-wrp">
                        <div class="guest-edit-box">
                            <p>Adults</p>
                            <div class="qty-container ms-auto">
                                <button class="qty-btn-minus" type="button"><i class="fa fa-minus"></i></button>
                                <input type="number" name="qty" value="0" class="input-qty" />
                                <button class="qty-btn-plus" type="button"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="guest-edit-box">
                            <p>Kids</p>
                            <div class="qty-container ms-auto">
                                <button class="qty-btn-minus" type="button"><i class="fa fa-minus"></i></button>
                                <input type="number" name="qty" value="0" class="input-qty" />
                                <button class="qty-btn-plus" type="button"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="guest-rsvp-attend">
                    <h6>RSVP</h6>
                    <div class="input-form">
                        <input type="radio" id="option1" name="foo" checked />
                        <label for="option1"><svg class="me-2" width="21" height="20" viewBox="0 0 21 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.5001 18.3334C15.0834 18.3334 18.8334 14.5834 18.8334 10.0001C18.8334 5.41675 15.0834 1.66675 10.5001 1.66675C5.91675 1.66675 2.16675 5.41675 2.16675 10.0001C2.16675 14.5834 5.91675 18.3334 10.5001 18.3334Z"
                                    stroke="#23AA26" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6.95825 9.99993L9.31659 12.3583L14.0416 7.6416" stroke="#23AA26"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>Attending</label>
                    </div>
                    <div class="input-form">
                        <input type="radio" id="option2" name="foo" />
                        <label for="option2"><svg class="me-2" width="21" height="20" viewBox="0 0 21 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.4974 18.3346C15.0807 18.3346 18.8307 14.5846 18.8307 10.0013C18.8307 5.41797 15.0807 1.66797 10.4974 1.66797C5.91406 1.66797 2.16406 5.41797 2.16406 10.0013C2.16406 14.5846 5.91406 18.3346 10.4974 18.3346Z"
                                    stroke="#E03137" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8.14062 12.3573L12.8573 7.64062" stroke="#E03137" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12.8573 12.3573L8.14062 7.64062" stroke="#E03137" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>Not Attending</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer rsvp-button-wrp">
                <button type="button" class="btn btn-secondary remove-btn" data-bs-dismiss="modal">Remove
                    Guest</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div> --}}
