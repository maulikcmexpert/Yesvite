<div class="category-main-dishesh potluckmain-{{$potluckkey}}">
    <div class="category-list">
        <div class="list-header">
            <span class="me-1 list-sub-head total-self-bring-{{$potluckkey}}">0</span>
            <div>
                <h5>{{$categoryName}}</h5>
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