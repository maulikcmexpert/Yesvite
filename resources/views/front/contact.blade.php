<?php
// dd($user['groups']);
?>
<x-front.advertise />
<style>
    #loading {
        display: none;
        text-align: center;
    }
</style>
<section class="contact-details">
    <div class="container">
        <div class="row">
            <x-front.sidebar :profileData="$user" />
            <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                <div class="contact-list">
                    <nav class="breadcrumb-nav" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('profile')}}">Profile</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contacts</li>
                        </ol>
                    </nav>
                    <div class="contact-title">
                        <h3>Contacts</h3>
                        <a href="#" class="cmn-btn" data-bs-toggle="modal" data-bs-target="#myModal1">Add New Contact</a>
                    </div>
                </div>
                <div class="contact-tab contact-user">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="#contact" aria-selected="true">Yestive</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="group-tab" data-bs-toggle="tab" data-bs-target="#group" type="button" role="tab" aria-controls="group" aria-selected="false">Groups</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="phone-tab" data-bs-toggle="tab" data-bs-target="#phone" type="button" role="tab" aria-controls="phone" aria-selected="false">Upload CSV</button>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active position-relative" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="position-relative">
                                <input type="search" class="search_name" placeholder="Search name">
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M22 22L20 20" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="product-scroll" id="product-scroll">
                                @if($user->groups->isNotEmpty())
                                <div class="popular-list">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <h5>Popular group lists</h5>
                                        <a href="#">See All</a>
                                    </div>
                                    <ul class="listing">
                                        @foreach ($user->groups as $value)

                                        <li>
                                            <h6>{{$value->name}}</h6>
                                            <span>{{$value->group_members_count.' Guests'}}</span>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                                @endif
                                <div class="user-contacts" id="yesviteUser">
                                    @include('front.ajax_contacts', ['yesviteUser' => $yesviteUser])
                                </div>
                            </div>
                            <div id="loader" style="display: none;">
                                <img src="{{asset('assets/front/loader.gif')}}" alt="loader" style="width:48px;height:48px;">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="phone" role="tabpanel" aria-labelledby="phone-tab">
                            <div class="position-relative">
                                <!-- <input type="search" class="search_phone" placeholder="Search Phone"> -->
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M22 22L20 20" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="product-scroll" id="product-scroll-groups">
                                <div class="user-contacts" id="yesvitePhones">
                                    @if($yesvitePhones->isEmpty())
                                    <form action="{{ route('import.csv') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="csv_file" class="pt-2">
                                        <button class="cmn-btn" type="submit">Import CSV</button>
                                    </form>
                                    @else
                                    @include('front.ajax_phones', ['yesvitePhones' => $yesvitePhones])
                                    @endif
                                </div>
                            </div>

                            <!-- <div class="user-contacts">
                                <div class="users-data">
                                    <div class="d-flex align-items-start">
                                        <div class="contact-img">
                                            <img src="./assets/image/user-img.svg" alt="contact-img">
                                        </div>
                                        <div class="text-start">
                                            <h5>Silvia Alegra</h5>
                                            <div>
                                                <a href="mailto:silvia@gmail.com"><svg class="me-1" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.91602 11.9582H4.08268C2.33268 11.9582 1.16602 11.0832 1.16602 9.0415V4.95817C1.16602 2.9165 2.33268 2.0415 4.08268 2.0415H9.91602C11.666 2.0415 12.8327 2.9165 12.8327 4.95817V9.0415C12.8327 11.0832 11.666 11.9582 9.91602 11.9582Z" stroke="black" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M9.91732 5.25L8.09148 6.70833C7.49065 7.18667 6.50482 7.18667 5.90398 6.70833L4.08398 5.25" stroke="black" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    silvia@gmail.com</a>
                                            </div>
                                            <div>
                                                <a href="tel">
                                                    <svg width="14" class="me-1" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.1805 13.2712C9.5213 13.2712 8.82714 13.1137 8.10964 12.8103C7.40964 12.5128 6.7038 12.1045 6.01547 11.6087C5.33297 11.107 4.6738 10.547 4.04964 9.93449C3.4313 9.31033 2.8713 8.65116 2.37547 7.97449C1.8738 7.27449 1.4713 6.57449 1.18547 5.89783C0.882135 5.17449 0.730469 4.47449 0.730469 3.81533C0.730469 3.36033 0.812135 2.92866 0.969635 2.52616C1.13297 2.11199 1.39547 1.72699 1.7513 1.39449C2.20047 0.951159 2.7138 0.729492 3.26214 0.729492C3.48964 0.729492 3.72297 0.781992 3.9213 0.875326C4.1488 0.980326 4.3413 1.13783 4.4813 1.34783L5.83464 3.25533C5.95714 3.42449 6.05047 3.58783 6.11464 3.75116C6.19047 3.92616 6.2313 4.10116 6.2313 4.27033C6.2313 4.49199 6.16714 4.70783 6.04464 4.91199C5.95714 5.06949 5.82297 5.23866 5.6538 5.40783L5.25714 5.82199C5.26297 5.83949 5.2688 5.85116 5.27464 5.86283C5.34464 5.98533 5.48464 6.19533 5.75297 6.51033C6.0388 6.83699 6.30714 7.13449 6.57547 7.40866C6.91964 7.74699 7.20547 8.01533 7.4738 8.23699C7.8063 8.51699 8.02214 8.65699 8.15047 8.72116L8.1388 8.75033L8.56464 8.33033C8.74547 8.14949 8.92047 8.01533 9.08964 7.92783C9.41047 7.72949 9.8188 7.69449 10.2271 7.86366C10.3788 7.92783 10.5421 8.01533 10.7171 8.13783L12.6538 9.51449C12.8696 9.66033 13.0271 9.84699 13.1205 10.0687C13.208 10.2903 13.2488 10.4945 13.2488 10.6987C13.2488 10.9787 13.1846 11.2587 13.0621 11.5212C12.9396 11.7837 12.788 12.0112 12.5955 12.2212C12.263 12.5887 11.9013 12.8512 11.4813 13.0203C11.0788 13.1837 10.6413 13.2712 10.1805 13.2712ZM3.26214 1.60449C2.9413 1.60449 2.6438 1.74449 2.35797 2.02449C2.08964 2.27533 1.90297 2.54949 1.7863 2.84699C1.6638 3.15033 1.60547 3.47116 1.60547 3.81533C1.60547 4.35783 1.7338 4.94699 1.99047 5.55366C2.25297 6.17199 2.62047 6.81366 3.08714 7.45533C3.5538 8.09699 4.08464 8.72116 4.66797 9.31033C5.2513 9.88783 5.8813 10.4245 6.5288 10.897C7.1588 11.3578 7.8063 11.7312 8.44797 11.9995C9.44547 12.4253 10.3788 12.5245 11.1488 12.2037C11.4463 12.0812 11.7088 11.8945 11.948 11.6262C12.0821 11.4803 12.1871 11.3228 12.2746 11.1362C12.3446 10.9903 12.3796 10.8387 12.3796 10.687C12.3796 10.5937 12.3621 10.5003 12.3155 10.3953C12.298 10.3603 12.263 10.2962 12.1521 10.2203L10.2155 8.84366C10.0988 8.76199 9.9938 8.70366 9.89464 8.66283C9.7663 8.61033 9.7138 8.55783 9.51547 8.68033C9.3988 8.73866 9.2938 8.82616 9.17714 8.94283L8.7338 9.38033C8.5063 9.60199 8.1563 9.65449 7.88797 9.55533L7.73047 9.48533C7.4913 9.35699 7.2113 9.15866 6.90214 8.89616C6.62214 8.65699 6.3188 8.37699 5.9513 8.01533C5.66547 7.72366 5.37964 7.41449 5.08214 7.07033C4.80797 6.74949 4.60964 6.47533 4.48714 6.24783L4.41714 6.07283C4.38214 5.93866 4.37047 5.86283 4.37047 5.78116C4.37047 5.57116 4.4463 5.38449 4.59214 5.23866L5.02964 4.78366C5.1463 4.66699 5.2338 4.55616 5.29214 4.45699C5.3388 4.38116 5.3563 4.31699 5.3563 4.25866C5.3563 4.21199 5.3388 4.14199 5.30964 4.07199C5.2688 3.97866 5.20464 3.87366 5.12297 3.76283L3.76964 1.84949C3.7113 1.76783 3.6413 1.70949 3.5538 1.66866C3.46047 1.62783 3.3613 1.60449 3.26214 1.60449ZM8.1388 8.75616L8.04547 9.15283L8.20297 8.74449C8.1738 8.73866 8.15047 8.74449 8.1388 8.75616Z" fill="black" />
                                                    </svg>
                                                    1-800-5587</a>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn edit-contact" data-bs-toggle="modal" data-bs-target="#myModal">Edit Contact</a>
                                </div>
                                <div class="users-data">
                                    <div class="d-flex align-items-start">
                                        <div class="contact-img">
                                            <img src="./assets/image/user-img.svg" alt="contact-img">
                                        </div>
                                        <div class="text-start">
                                            <h5>Silvia Alegra</h5>
                                            <div>
                                                <a href="mailto:silvia@gmail.com"><svg class="me-1" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.91602 11.9582H4.08268C2.33268 11.9582 1.16602 11.0832 1.16602 9.0415V4.95817C1.16602 2.9165 2.33268 2.0415 4.08268 2.0415H9.91602C11.666 2.0415 12.8327 2.9165 12.8327 4.95817V9.0415C12.8327 11.0832 11.666 11.9582 9.91602 11.9582Z" stroke="black" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M9.91732 5.25L8.09148 6.70833C7.49065 7.18667 6.50482 7.18667 5.90398 6.70833L4.08398 5.25" stroke="black" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    silvia@gmail.com</a>
                                            </div>
                                            <div>
                                                <a href="tel">
                                                    <svg width="14" class="me-1" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.1805 13.2712C9.5213 13.2712 8.82714 13.1137 8.10964 12.8103C7.40964 12.5128 6.7038 12.1045 6.01547 11.6087C5.33297 11.107 4.6738 10.547 4.04964 9.93449C3.4313 9.31033 2.8713 8.65116 2.37547 7.97449C1.8738 7.27449 1.4713 6.57449 1.18547 5.89783C0.882135 5.17449 0.730469 4.47449 0.730469 3.81533C0.730469 3.36033 0.812135 2.92866 0.969635 2.52616C1.13297 2.11199 1.39547 1.72699 1.7513 1.39449C2.20047 0.951159 2.7138 0.729492 3.26214 0.729492C3.48964 0.729492 3.72297 0.781992 3.9213 0.875326C4.1488 0.980326 4.3413 1.13783 4.4813 1.34783L5.83464 3.25533C5.95714 3.42449 6.05047 3.58783 6.11464 3.75116C6.19047 3.92616 6.2313 4.10116 6.2313 4.27033C6.2313 4.49199 6.16714 4.70783 6.04464 4.91199C5.95714 5.06949 5.82297 5.23866 5.6538 5.40783L5.25714 5.82199C5.26297 5.83949 5.2688 5.85116 5.27464 5.86283C5.34464 5.98533 5.48464 6.19533 5.75297 6.51033C6.0388 6.83699 6.30714 7.13449 6.57547 7.40866C6.91964 7.74699 7.20547 8.01533 7.4738 8.23699C7.8063 8.51699 8.02214 8.65699 8.15047 8.72116L8.1388 8.75033L8.56464 8.33033C8.74547 8.14949 8.92047 8.01533 9.08964 7.92783C9.41047 7.72949 9.8188 7.69449 10.2271 7.86366C10.3788 7.92783 10.5421 8.01533 10.7171 8.13783L12.6538 9.51449C12.8696 9.66033 13.0271 9.84699 13.1205 10.0687C13.208 10.2903 13.2488 10.4945 13.2488 10.6987C13.2488 10.9787 13.1846 11.2587 13.0621 11.5212C12.9396 11.7837 12.788 12.0112 12.5955 12.2212C12.263 12.5887 11.9013 12.8512 11.4813 13.0203C11.0788 13.1837 10.6413 13.2712 10.1805 13.2712ZM3.26214 1.60449C2.9413 1.60449 2.6438 1.74449 2.35797 2.02449C2.08964 2.27533 1.90297 2.54949 1.7863 2.84699C1.6638 3.15033 1.60547 3.47116 1.60547 3.81533C1.60547 4.35783 1.7338 4.94699 1.99047 5.55366C2.25297 6.17199 2.62047 6.81366 3.08714 7.45533C3.5538 8.09699 4.08464 8.72116 4.66797 9.31033C5.2513 9.88783 5.8813 10.4245 6.5288 10.897C7.1588 11.3578 7.8063 11.7312 8.44797 11.9995C9.44547 12.4253 10.3788 12.5245 11.1488 12.2037C11.4463 12.0812 11.7088 11.8945 11.948 11.6262C12.0821 11.4803 12.1871 11.3228 12.2746 11.1362C12.3446 10.9903 12.3796 10.8387 12.3796 10.687C12.3796 10.5937 12.3621 10.5003 12.3155 10.3953C12.298 10.3603 12.263 10.2962 12.1521 10.2203L10.2155 8.84366C10.0988 8.76199 9.9938 8.70366 9.89464 8.66283C9.7663 8.61033 9.7138 8.55783 9.51547 8.68033C9.3988 8.73866 9.2938 8.82616 9.17714 8.94283L8.7338 9.38033C8.5063 9.60199 8.1563 9.65449 7.88797 9.55533L7.73047 9.48533C7.4913 9.35699 7.2113 9.15866 6.90214 8.89616C6.62214 8.65699 6.3188 8.37699 5.9513 8.01533C5.66547 7.72366 5.37964 7.41449 5.08214 7.07033C4.80797 6.74949 4.60964 6.47533 4.48714 6.24783L4.41714 6.07283C4.38214 5.93866 4.37047 5.86283 4.37047 5.78116C4.37047 5.57116 4.4463 5.38449 4.59214 5.23866L5.02964 4.78366C5.1463 4.66699 5.2338 4.55616 5.29214 4.45699C5.3388 4.38116 5.3563 4.31699 5.3563 4.25866C5.3563 4.21199 5.3388 4.14199 5.30964 4.07199C5.2688 3.97866 5.20464 3.87366 5.12297 3.76283L3.76964 1.84949C3.7113 1.76783 3.6413 1.70949 3.5538 1.66866C3.46047 1.62783 3.3613 1.60449 3.26214 1.60449ZM8.1388 8.75616L8.04547 9.15283L8.20297 8.74449C8.1738 8.73866 8.15047 8.74449 8.1388 8.75616Z" fill="black" />
                                                    </svg>
                                                    1-800-5587</a>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn edit-contact" data-bs-toggle="modal" data-bs-target="#myModal">Edit Contact</a>
                                </div>
                                <div class="users-data">
                                    <div class="d-flex align-items-start">
                                        <div class="contact-img">
                                            <img src="./assets/image/user-img.svg" alt="contact-img">
                                        </div>
                                        <div class="text-start">
                                            <h5>Silvia Alegra</h5>
                                            <div>
                                                <a href="mailto:silvia@gmail.com"><svg class="me-1" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.91602 11.9582H4.08268C2.33268 11.9582 1.16602 11.0832 1.16602 9.0415V4.95817C1.16602 2.9165 2.33268 2.0415 4.08268 2.0415H9.91602C11.666 2.0415 12.8327 2.9165 12.8327 4.95817V9.0415C12.8327 11.0832 11.666 11.9582 9.91602 11.9582Z" stroke="black" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M9.91732 5.25L8.09148 6.70833C7.49065 7.18667 6.50482 7.18667 5.90398 6.70833L4.08398 5.25" stroke="black" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    silvia@gmail.com</a>
                                            </div>
                                            <div>
                                                <a href="tel">
                                                    <svg width="14" class="me-1" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.1805 13.2712C9.5213 13.2712 8.82714 13.1137 8.10964 12.8103C7.40964 12.5128 6.7038 12.1045 6.01547 11.6087C5.33297 11.107 4.6738 10.547 4.04964 9.93449C3.4313 9.31033 2.8713 8.65116 2.37547 7.97449C1.8738 7.27449 1.4713 6.57449 1.18547 5.89783C0.882135 5.17449 0.730469 4.47449 0.730469 3.81533C0.730469 3.36033 0.812135 2.92866 0.969635 2.52616C1.13297 2.11199 1.39547 1.72699 1.7513 1.39449C2.20047 0.951159 2.7138 0.729492 3.26214 0.729492C3.48964 0.729492 3.72297 0.781992 3.9213 0.875326C4.1488 0.980326 4.3413 1.13783 4.4813 1.34783L5.83464 3.25533C5.95714 3.42449 6.05047 3.58783 6.11464 3.75116C6.19047 3.92616 6.2313 4.10116 6.2313 4.27033C6.2313 4.49199 6.16714 4.70783 6.04464 4.91199C5.95714 5.06949 5.82297 5.23866 5.6538 5.40783L5.25714 5.82199C5.26297 5.83949 5.2688 5.85116 5.27464 5.86283C5.34464 5.98533 5.48464 6.19533 5.75297 6.51033C6.0388 6.83699 6.30714 7.13449 6.57547 7.40866C6.91964 7.74699 7.20547 8.01533 7.4738 8.23699C7.8063 8.51699 8.02214 8.65699 8.15047 8.72116L8.1388 8.75033L8.56464 8.33033C8.74547 8.14949 8.92047 8.01533 9.08964 7.92783C9.41047 7.72949 9.8188 7.69449 10.2271 7.86366C10.3788 7.92783 10.5421 8.01533 10.7171 8.13783L12.6538 9.51449C12.8696 9.66033 13.0271 9.84699 13.1205 10.0687C13.208 10.2903 13.2488 10.4945 13.2488 10.6987C13.2488 10.9787 13.1846 11.2587 13.0621 11.5212C12.9396 11.7837 12.788 12.0112 12.5955 12.2212C12.263 12.5887 11.9013 12.8512 11.4813 13.0203C11.0788 13.1837 10.6413 13.2712 10.1805 13.2712ZM3.26214 1.60449C2.9413 1.60449 2.6438 1.74449 2.35797 2.02449C2.08964 2.27533 1.90297 2.54949 1.7863 2.84699C1.6638 3.15033 1.60547 3.47116 1.60547 3.81533C1.60547 4.35783 1.7338 4.94699 1.99047 5.55366C2.25297 6.17199 2.62047 6.81366 3.08714 7.45533C3.5538 8.09699 4.08464 8.72116 4.66797 9.31033C5.2513 9.88783 5.8813 10.4245 6.5288 10.897C7.1588 11.3578 7.8063 11.7312 8.44797 11.9995C9.44547 12.4253 10.3788 12.5245 11.1488 12.2037C11.4463 12.0812 11.7088 11.8945 11.948 11.6262C12.0821 11.4803 12.1871 11.3228 12.2746 11.1362C12.3446 10.9903 12.3796 10.8387 12.3796 10.687C12.3796 10.5937 12.3621 10.5003 12.3155 10.3953C12.298 10.3603 12.263 10.2962 12.1521 10.2203L10.2155 8.84366C10.0988 8.76199 9.9938 8.70366 9.89464 8.66283C9.7663 8.61033 9.7138 8.55783 9.51547 8.68033C9.3988 8.73866 9.2938 8.82616 9.17714 8.94283L8.7338 9.38033C8.5063 9.60199 8.1563 9.65449 7.88797 9.55533L7.73047 9.48533C7.4913 9.35699 7.2113 9.15866 6.90214 8.89616C6.62214 8.65699 6.3188 8.37699 5.9513 8.01533C5.66547 7.72366 5.37964 7.41449 5.08214 7.07033C4.80797 6.74949 4.60964 6.47533 4.48714 6.24783L4.41714 6.07283C4.38214 5.93866 4.37047 5.86283 4.37047 5.78116C4.37047 5.57116 4.4463 5.38449 4.59214 5.23866L5.02964 4.78366C5.1463 4.66699 5.2338 4.55616 5.29214 4.45699C5.3388 4.38116 5.3563 4.31699 5.3563 4.25866C5.3563 4.21199 5.3388 4.14199 5.30964 4.07199C5.2688 3.97866 5.20464 3.87366 5.12297 3.76283L3.76964 1.84949C3.7113 1.76783 3.6413 1.70949 3.5538 1.66866C3.46047 1.62783 3.3613 1.60449 3.26214 1.60449ZM8.1388 8.75616L8.04547 9.15283L8.20297 8.74449C8.1738 8.73866 8.15047 8.74449 8.1388 8.75616Z" fill="black" />
                                                    </svg>
                                                    1-800-5587</a>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn edit-contact" data-bs-toggle="modal" data-bs-target="#myModal">Edit Contact</a>
                                </div>
                                <div class="users-data">
                                    <div class="d-flex align-items-start">
                                        <div class="contact-img">
                                            <img src="./assets/image/user-img.svg" alt="contact-img">
                                        </div>
                                        <div class="text-start">
                                            <h5>Silvia Alegra</h5>
                                            <div>
                                                <a href="mailto:silvia@gmail.com"><svg class="me-1" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.91602 11.9582H4.08268C2.33268 11.9582 1.16602 11.0832 1.16602 9.0415V4.95817C1.16602 2.9165 2.33268 2.0415 4.08268 2.0415H9.91602C11.666 2.0415 12.8327 2.9165 12.8327 4.95817V9.0415C12.8327 11.0832 11.666 11.9582 9.91602 11.9582Z" stroke="black" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M9.91732 5.25L8.09148 6.70833C7.49065 7.18667 6.50482 7.18667 5.90398 6.70833L4.08398 5.25" stroke="black" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    silvia@gmail.com</a>
                                            </div>
                                            <div>
                                                <a href="tel">
                                                    <svg width="14" class="me-1" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.1805 13.2712C9.5213 13.2712 8.82714 13.1137 8.10964 12.8103C7.40964 12.5128 6.7038 12.1045 6.01547 11.6087C5.33297 11.107 4.6738 10.547 4.04964 9.93449C3.4313 9.31033 2.8713 8.65116 2.37547 7.97449C1.8738 7.27449 1.4713 6.57449 1.18547 5.89783C0.882135 5.17449 0.730469 4.47449 0.730469 3.81533C0.730469 3.36033 0.812135 2.92866 0.969635 2.52616C1.13297 2.11199 1.39547 1.72699 1.7513 1.39449C2.20047 0.951159 2.7138 0.729492 3.26214 0.729492C3.48964 0.729492 3.72297 0.781992 3.9213 0.875326C4.1488 0.980326 4.3413 1.13783 4.4813 1.34783L5.83464 3.25533C5.95714 3.42449 6.05047 3.58783 6.11464 3.75116C6.19047 3.92616 6.2313 4.10116 6.2313 4.27033C6.2313 4.49199 6.16714 4.70783 6.04464 4.91199C5.95714 5.06949 5.82297 5.23866 5.6538 5.40783L5.25714 5.82199C5.26297 5.83949 5.2688 5.85116 5.27464 5.86283C5.34464 5.98533 5.48464 6.19533 5.75297 6.51033C6.0388 6.83699 6.30714 7.13449 6.57547 7.40866C6.91964 7.74699 7.20547 8.01533 7.4738 8.23699C7.8063 8.51699 8.02214 8.65699 8.15047 8.72116L8.1388 8.75033L8.56464 8.33033C8.74547 8.14949 8.92047 8.01533 9.08964 7.92783C9.41047 7.72949 9.8188 7.69449 10.2271 7.86366C10.3788 7.92783 10.5421 8.01533 10.7171 8.13783L12.6538 9.51449C12.8696 9.66033 13.0271 9.84699 13.1205 10.0687C13.208 10.2903 13.2488 10.4945 13.2488 10.6987C13.2488 10.9787 13.1846 11.2587 13.0621 11.5212C12.9396 11.7837 12.788 12.0112 12.5955 12.2212C12.263 12.5887 11.9013 12.8512 11.4813 13.0203C11.0788 13.1837 10.6413 13.2712 10.1805 13.2712ZM3.26214 1.60449C2.9413 1.60449 2.6438 1.74449 2.35797 2.02449C2.08964 2.27533 1.90297 2.54949 1.7863 2.84699C1.6638 3.15033 1.60547 3.47116 1.60547 3.81533C1.60547 4.35783 1.7338 4.94699 1.99047 5.55366C2.25297 6.17199 2.62047 6.81366 3.08714 7.45533C3.5538 8.09699 4.08464 8.72116 4.66797 9.31033C5.2513 9.88783 5.8813 10.4245 6.5288 10.897C7.1588 11.3578 7.8063 11.7312 8.44797 11.9995C9.44547 12.4253 10.3788 12.5245 11.1488 12.2037C11.4463 12.0812 11.7088 11.8945 11.948 11.6262C12.0821 11.4803 12.1871 11.3228 12.2746 11.1362C12.3446 10.9903 12.3796 10.8387 12.3796 10.687C12.3796 10.5937 12.3621 10.5003 12.3155 10.3953C12.298 10.3603 12.263 10.2962 12.1521 10.2203L10.2155 8.84366C10.0988 8.76199 9.9938 8.70366 9.89464 8.66283C9.7663 8.61033 9.7138 8.55783 9.51547 8.68033C9.3988 8.73866 9.2938 8.82616 9.17714 8.94283L8.7338 9.38033C8.5063 9.60199 8.1563 9.65449 7.88797 9.55533L7.73047 9.48533C7.4913 9.35699 7.2113 9.15866 6.90214 8.89616C6.62214 8.65699 6.3188 8.37699 5.9513 8.01533C5.66547 7.72366 5.37964 7.41449 5.08214 7.07033C4.80797 6.74949 4.60964 6.47533 4.48714 6.24783L4.41714 6.07283C4.38214 5.93866 4.37047 5.86283 4.37047 5.78116C4.37047 5.57116 4.4463 5.38449 4.59214 5.23866L5.02964 4.78366C5.1463 4.66699 5.2338 4.55616 5.29214 4.45699C5.3388 4.38116 5.3563 4.31699 5.3563 4.25866C5.3563 4.21199 5.3388 4.14199 5.30964 4.07199C5.2688 3.97866 5.20464 3.87366 5.12297 3.76283L3.76964 1.84949C3.7113 1.76783 3.6413 1.70949 3.5538 1.66866C3.46047 1.62783 3.3613 1.60449 3.26214 1.60449ZM8.1388 8.75616L8.04547 9.15283L8.20297 8.74449C8.1738 8.73866 8.15047 8.74449 8.1388 8.75616Z" fill="black" />
                                                    </svg>
                                                    1-800-5587</a>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn edit-contact" data-bs-toggle="modal" data-bs-target="#myModal">Edit Contact</a>
                                </div>
                            </div>-->
                        </div>
                        <div class="tab-pane fade" id="group" role="tabpanel" aria-labelledby="group-tab">
                            <div class="position-relative">
                                <input type="search" class="search_group" placeholder="Search Group">
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M22 22L20 20" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>

                            <!-- <div class="user-contacts">
                                @foreach ($groups as $value)

                                <div class="users-data">
                                    <div class="d-flex align-items-start">

                                        <div class="text-start">
                                            <h5>{{$value->name}}</h5>
                                            <div> -->
                            <!-- <span>{{$value->group_members_count.' Guests'}}</span> -->
                            <!-- </div>
                                            <div>

                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn edit-contact" data-bs-toggle="modal" data-bs-target="#myModal">Edit Contact</a>
                                </div>
                                @endforeach -->

                            <div class="product-scroll" id="product-scroll-groups">

                                <div class="user-contacts" id="yesviteGroups">
                                    @include('front.ajax_groups', ['yesviteGroups' => $yesviteGroups])
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>




<!-- ======== edit-model ========= -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Contact</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="login-form-wrap">
                    <form method="POST" id="edit_contact_form" action="{{route('.saveeditcontact')}}">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="input-form">
                                    <input type="text" class="form-control" id="edit_Fname" name="edit_Fname">
                                    <label for="Fname" class="floating-label">First Name<span>*</span></label>
                                    <div class="label-error">
                                        <label id="edit_Fname-error" class="error" for="edit_Fname"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="input-form">
                                    <input type="text" class="form-control" id="edit_Lname" name="edit_Lname">
                                    <label for="Lname" class="floating-label">Last Name<span>*</span></label>
                                    <div class="label-error">
                                        <label id="edit_Lname-error" class="error" for="edit_Lname"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="input-form">
                                    <input type="email" class="form-control inputText" id="email" name="email" required>
                                    <label for="email" class="form-label input-field floating-label">Work Email
                                        Address<span class="required">*</span></label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="input-form add-contact-selectbox">
                                    <input type="text" class="phone_number border-0" name="countryCode" readonly>
                                    <input type="text" class="form-control edit_phone" id="phone_number" name="phone_number" value="">
                                    <label for="phone" class="floating-label">Phone
                                        Number<span>*</span></label>
                                    <div class="label-error">
                                        <label id="phone_number-error" class="error" for="phone_number"></label>
                                    </div>
                                    <input type="hidden" name="country_code" id="country_code" value="">
                                    <input type="hidden" class="form-control inputText" id="edit_id" name="edit_id">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-end">
                                    <button type="button" id="save_edit_contact" class="cmn-btn save-btn">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myModal1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Contact</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="login-form-wrap">
                    <form method="POST" id="add_contact" action="{{route('.addcontact',encrypt($user->id))}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-form">
                                    <input type="text" class="form-control inputText" id="Fname" name="Fname">
                                    <label for="Fname" class="floating-label">First
                                        Name</label>
                                    <div class="label-error">
                                        <label id="Fname-error" class="error" for="Fname"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-form">
                                    <input type="text" class="form-control inputText" id="Lname" name="Lname">
                                    <label for="Lname" class="floating-label">Last
                                        Name</label>
                                    <div class="label-error">
                                        <label id="Lname-error" class="error" for="Lname"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="input-form">
                                    <input type="email" class="form-control addnew_email" id="email" name="email" autocomplete="off">
                                    <label for="email" class="floating-label">Work Email
                                        Address<span>*</span></label>
                                    <div class="label-error">
                                        <label id="email-error" class="error" for="email"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="input-form add-contact-selectbox">
                                    <input type="text" class="phone_number border-0" name="countryCode" readonly>
                                    <input type="text" class="form-control addnew_contact" id="phone_number" name="phone_number">
                                    <label for="phone" class="floating-label">Phone
                                        Number<span>*</span></label>
                                    <div class="label-error">
                                        <label id="phone_number-error" class="error" for="phone_number"></label>
                                    </div>
                                    <input type="hidden" name="country_code" id="country_code" value="">
                                    <div class="label-error">
                                        <label id="phone_number-error" class="error" for="phone_number"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="button" id="save_contact" class="cmn-btn save-btn">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>