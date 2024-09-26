<div class="category-main-dishesh potluckmain-{{$potluckkey}}">
    <div class="category-list">
        <div class="list-header">
            <span class="me-1 list-sub-head total-self-bring-{{$potluckkey}}">0</span>
            <div>
                <h5 class="category_name">{{$categoryName}}</h5>
                <p>Total Commited</p>
            </div>
            <div class="ms-auto d-flex align-items-center ">
                <span class="me-2 missing-category-h6-{{$potluckkey}} missing-category-svg-{{$potluckkey}}" style="display: none;">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.5067 9.61399L9.23998 1.93398C8.66665 0.900651 7.87332 0.333984 6.99998 0.333984C6.12665 0.333984 5.33332 0.900651 4.75998 1.93398L0.493318 9.61399C-0.0466816 10.594 -0.106682 11.534 0.326652 12.274C0.759985 13.014 1.61332 13.4207 2.73332 13.4207H11.2667C12.3867 13.4207 13.24 13.014 13.6733 12.274C14.1067 11.534 14.0467 10.5873 13.5067 9.61399ZM6.49998 5.00065C6.49998 4.72732 6.72665 4.50065 6.99998 4.50065C7.27332 4.50065 7.49998 4.72732 7.49998 5.00065V8.33398C7.49998 8.60732 7.27332 8.83398 6.99998 8.83398C6.72665 8.83398 6.49998 8.60732 6.49998 8.33398V5.00065ZM7.47332 10.8073C7.43998 10.834 7.40665 10.8607 7.37332 10.8873C7.33332 10.914 7.29332 10.934 7.25332 10.9473C7.21332 10.9673 7.17332 10.9807 7.12665 10.9873C7.08665 10.994 7.03998 11.0007 6.99998 11.0007C6.95998 11.0007 6.91332 10.994 6.86665 10.9873C6.82665 10.9807 6.78665 10.9673 6.74665 10.9473C6.70665 10.934 6.66665 10.914 6.62665 10.8873C6.59332 10.8607 6.55998 10.834 6.52665 10.8073C6.40665 10.6807 6.33332 10.5073 6.33332 10.334C6.33332 10.1607 6.40665 9.98732 6.52665 9.86065C6.55998 9.83399 6.59332 9.80732 6.62665 9.78065C6.66665 9.75398 6.70665 9.73398 6.74665 9.72065C6.78665 9.70065 6.82665 9.68732 6.86665 9.68065C6.95332 9.66065 7.04665 9.66065 7.12665 9.68065C7.17332 9.68732 7.21332 9.70065 7.25332 9.72065C7.29332 9.73398 7.33332 9.75398 7.37332 9.78065C7.40665 9.80732 7.43998 9.83399 7.47332 9.86065C7.59332 9.98732 7.66665 10.1607 7.66665 10.334C7.66665 10.5073 7.59332 10.6807 7.47332 10.8073Z" fill="#F73C71" />
                    </svg>
                </span>
                <h6 class="me-2 missing-category-h6-{{$potluckkey}}" style="display: none;"><span id="missing-category-{{$potluckkey}}">{{$categoryQuantity}}</span> Missing</h6>
                <a href="#" class="me-3" id="potluck-{{$potluckkey}}" onclick="toggleSidebar('sidebar_addcategoryitem'); setPotluckActivekey({{$potluckkey}},'{{$categoryName}}')">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.9998 0.166016C5.03067 0.166016 0.166504 5.03018 0.166504 10.9993C0.166504 16.9685 5.03067 21.8327 10.9998 21.8327C16.969 21.8327 21.8332 16.9685 21.8332 10.9993C21.8332 5.03018 16.969 0.166016 10.9998 0.166016ZM15.3332 11.8118H11.8123V15.3327C11.8123 15.7768 11.444 16.1452 10.9998 16.1452C10.5557 16.1452 10.1873 15.7768 10.1873 15.3327V11.8118H6.6665C6.22234 11.8118 5.854 11.4435 5.854 10.9993C5.854 10.5552 6.22234 10.1868 6.6665 10.1868H10.1873V6.66602C10.1873 6.22185 10.5557 5.85352 10.9998 5.85352C11.444 5.85352 11.8123 6.22185 11.8123 6.66602V10.1868H15.3332C15.7773 10.1868 16.1457 10.5552 16.1457 10.9993C16.1457 11.4435 15.7773 11.8118 15.3332 11.8118Z" fill="#F73C71" />
                    </svg>
                </a>
                <a href="#" type="button" class="delete_potluck_category" data-id="{{$potluckkey}}">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.5 4.98307C14.725 4.70807 11.9333 4.56641 9.15 4.56641C7.5 4.56641 5.85 4.64974 4.2 4.81641L2.5 4.98307" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.0835 4.14102L7.26683 3.04935C7.40016 2.25768 7.50016 1.66602 8.9085 1.66602L11.0918 1.66602C12.5002 1.66602 12.6085 2.29102 12.7335 3.05768L12.9168 4.14102" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15.7082 7.61719L15.1665 16.0089C15.0748 17.3172 14.9998 18.3339 12.6748 18.3339H7.32484C4.99984 18.3339 4.92484 17.3172 4.83317 16.0089L4.2915 7.61719" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8.6084 13.75H11.3834" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.9165 10.416H12.0832" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <div class="potlak-edit-wrp dropdown">
                    <i class="fa-solid fa-ellipsis-vertical dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"></i>
                    <div class="potlak-edit-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <ul>
                            <li class="edit_potluck_category" data-id="{{$potluckkey}}" data-category_name="{{$categoryName}}" data-category_quantity="{{$categoryQuantity}}">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5001 18.9577L7.50008 18.9577C2.97508 18.9577 1.04175 17.0243 1.04175 12.4993L1.04175 7.49935C1.04175 2.97435 2.97508 1.04102 7.50008 1.04102L9.16675 1.04102C9.50842 1.04102 9.79175 1.32435 9.79175 1.66602C9.79175 2.00768 9.50842 2.29102 9.16675 2.29102L7.50008 2.29102C3.65841 2.29102 2.29175 3.65768 2.29175 7.49935L2.29175 12.4993C2.29175 16.341 3.65841 17.7077 7.50008 17.7077L12.5001 17.7077C16.3417 17.7077 17.7084 16.341 17.7084 12.4993L17.7084 10.8327C17.7084 10.491 17.9917 10.2077 18.3334 10.2077C18.6751 10.2077 18.9584 10.491 18.9584 10.8327L18.9584 12.4993C18.9584 17.0243 17.0251 18.9577 12.5001 18.9577Z" fill="#94A3B8"/>
                                <path d="M7.08336 14.7424C6.57503 14.7424 6.10836 14.5591 5.76669 14.2258C5.35836 13.8174 5.18336 13.2258 5.27503 12.6008L5.63336 10.0924C5.70003 9.60911 6.01669 8.98411 6.35836 8.64245L12.925 2.07578C14.5834 0.417448 16.2667 0.417448 17.925 2.07578C18.8334 2.98411 19.2417 3.90911 19.1584 4.83411C19.0834 5.58411 18.6834 6.31745 17.925 7.06745L11.3584 13.6341C11.0167 13.9758 10.3917 14.2924 9.90836 14.3591L7.40003 14.7174C7.29169 14.7424 7.18336 14.7424 7.08336 14.7424ZM13.8084 2.95911L7.24169 9.52578C7.08336 9.68411 6.90003 10.0508 6.86669 10.2674L6.50836 12.7758C6.47503 13.0174 6.52503 13.2174 6.65003 13.3424C6.77503 13.4674 6.97503 13.5174 7.21669 13.4841L9.72503 13.1258C9.94169 13.0924 10.3167 12.9091 10.4667 12.7508L17.0334 6.18411C17.575 5.64245 17.8584 5.15911 17.9 4.70911C17.95 4.16745 17.6667 3.59245 17.0334 2.95078C15.7 1.61745 14.7834 1.99245 13.8084 2.95911Z" fill="#94A3B8"/>
                                <path d="M16.5416 8.19124C16.4832 8.19124 16.4249 8.18291 16.3749 8.16624C14.1832 7.54957 12.4416 5.80791 11.8249 3.61624C11.7332 3.28291 11.9249 2.94124 12.2582 2.84124C12.5916 2.74957 12.9332 2.94124 13.0249 3.27457C13.5249 5.04957 14.9332 6.45791 16.7082 6.95791C17.0416 7.04957 17.2332 7.39957 17.1416 7.73291C17.0666 8.01624 16.8166 8.19124 16.5416 8.19124Z" fill="#94A3B8"/>
                                </svg>
                                Edit
                            </li>
                            <li class="delete_potluck_category" data-id="{{$potluckkey}}">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 3.98763C11.78 3.76763 9.54667 3.6543 7.32 3.6543C6 3.6543 4.68 3.72096 3.36 3.8543L2 3.98763" stroke="#F73C71" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.6665 3.31398L5.81317 2.44065C5.91984 1.80732 5.99984 1.33398 7.1265 1.33398H8.87317C9.99984 1.33398 10.0865 1.83398 10.1865 2.44732L10.3332 3.31398" stroke="#F73C71" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.5664 6.09375L12.1331 12.8071C12.0598 13.8537 11.9998 14.6671 10.1398 14.6671H5.85977C3.99977 14.6671 3.93977 13.8537 3.86644 12.8071L3.43311 6.09375" stroke="#F73C71" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.88672 11H9.10672" stroke="#F73C71" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.3335 8.33398H9.66683" stroke="#F73C71" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Delete   
                            </li>
                        </ul>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="list-body d-flex align-items-center no_item">
            <span class="me-2">
                <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.99984 14.166C10.6732 14.166 13.6665 11.1727 13.6665 7.49935C13.6665 3.82602 10.6732 0.832682 6.99984 0.832682C3.3265 0.832682 0.33317 3.82602 0.33317 7.49935C0.33317 11.1727 3.3265 14.166 6.99984 14.166ZM7.49984 10.166C7.49984 10.4393 7.27317 10.666 6.99984 10.666C6.7265 10.666 6.49984 10.4393 6.49984 10.166V6.83268C6.49984 6.55935 6.7265 6.33268 6.99984 6.33268C7.27317 6.33268 7.49984 6.55935 7.49984 6.83268V10.166ZM6.3865 4.57935C6.41984 4.49268 6.4665 4.42602 6.5265 4.35935C6.59317 4.29935 6.6665 4.25268 6.7465 4.21935C6.8265 4.18602 6.91317 4.16602 6.99984 4.16602C7.0865 4.16602 7.17317 4.18602 7.25317 4.21935C7.33317 4.25268 7.4065 4.29935 7.47317 4.35935C7.53317 4.42602 7.57984 4.49268 7.61317 4.57935C7.6465 4.65935 7.6665 4.74602 7.6665 4.83268C7.6665 4.91935 7.6465 5.00602 7.61317 5.08602C7.57984 5.16602 7.53317 5.23935 7.47317 5.30602C7.4065 5.36602 7.33317 5.41268 7.25317 5.44602C7.09317 5.51268 6.9065 5.51268 6.7465 5.44602C6.6665 5.41268 6.59317 5.36602 6.5265 5.30602C6.4665 5.23935 6.41984 5.16602 6.3865 5.08602C6.35317 5.00602 6.33317 4.91935 6.33317 4.83268C6.33317 4.74602 6.35317 4.65935 6.3865 4.57935Z" fill="#FD5983" />
                </svg>
            </span>
            <p>Nobody has added anything yet</h5>
        </div>
        <div class="list-slide list-slide-{{$potluckkey}}">
        </div>
    </div>
    <a href="#" class="listing-arrow">
        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.9401 1.71289L8.05006 6.60289C7.47256 7.18039 6.52756 7.18039 5.95006 6.60289L1.06006 1.71289" stroke="#CBD5E1" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>
</div>