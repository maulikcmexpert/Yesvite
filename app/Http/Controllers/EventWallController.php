<?php

namespace App\Http\Controllers;

use App\Models\{
    Event,
    EventPost,
    EventPostComment,
    EventInvitedUser,
    Notification,
    EventImage,
    EventGiftRegistry,
    EventPostImage,
    EventPotluckCategory,
    EventPotluckCategoryItem,
    UserPotluckItem,
    PostControl,
    EventPostReaction,
    EventUserStory,
    UserSeenStory,
    EventPostPoll,
    EventPostPollOption,
    User,
    UserEventStory,
    UserEventPollData
};
use Spatie\Image\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class EventWallController extends Controller
{
    protected $perPage;

    public function __construct()
    {
        $this->perPage = 5;
    }
    public function index(String $id)
    {
        $title = 'event wall';
        $user  = Auth::guard('web')->user();


        $event = decrypt($id);
        $encrypt_event_id = $id;
        $page = 'front.event_wall.event_wall';

        if ($event == null) {
            return response()->json(['status' => 0, 'message' => "Json invalid"]);
        }

        $users = User::withCount(

            [
                'event' => function ($query) {
                    $query->where('is_draft_save', '0');
                },
                'event_post' => function ($query) {
                    $query->where('post_type', '1');
                },
                'event_post_comment',
            ]
        )->findOrFail($user->id);
        $users['events'] =   Event::where(['user_id' => $users->id, 'is_draft_save' => '0'])->count();
        $users['profile'] = ($users->profile != null) ? asset('storage/profile/' . $users->profile) : "";
        $users['bg_profile'] = ($users->bg_profile != null) ? asset('storage/bg_profile/' . $users->bg_profile) : asset('assets/front/image/Frame 1000005835.png');

        $currentDateTime = Carbon::now();


        $eventStoriesLists = EventUserStory::with(['user', 'user_event_story' => function ($query) use ($currentDateTime) {
            $query->where('created_at', '>', now()->subHours(24));
        }])
            ->where('created_at', '>', now()->subHours(24))
            ->where('event_id', $event)
            ->where('user_id', '!=', $user->id)->get();
        // }dd
        // dd($eventStoriesLists);
        $storiesList = [];
        if (!empty($eventStoriesLists)) {
            foreach ($eventStoriesLists as $value) {
                $storiesDetaill['id'] =  $value->id;
                $storiesDetaill['user_id'] =  $value->user->id;
                $storiesDetaill['username'] =  $value->user->firstname . ' ' . $value->user->lastname;
                $storiesDetaill['profile'] =  empty($value->user->profile) ? "" : asset('storage/profile/' . $value->user->profile);
                $storyAlldata = [];
                foreach ($value->user_event_story as $storyVal) {
                    $storiesData['id'] = $storyVal->id;
                    $storiesData['storyurl'] = empty($storyVal->story) ? "" : asset('storage/event_user_stories/' . $storyVal->story);
                    $storiesData['type'] = $storyVal->type;
                    $storiesData['post_time'] =  $this->setpostTime($storyVal->created_at);
                    $checkISeen = UserSeenStory::where(['user_id' => $user->id, 'user_event_story_id' => $storyVal->id])->count();
                    $storiesData['is_seen'] = ($checkISeen != 0) ? "1" : "0";
                    if ($storyVal->type == 'video') {
                        $storiesData['video_duration'] = (!empty($storyVal->duration)) ? $storyVal->duration : "";
                    }
                    $storiesData['created_at'] =  $storyVal->created_at;
                    $storyAlldata[] = $storiesData;
                }
                $storiesDetaill['story'] = $storyAlldata;
                $storiesList[] = $storiesDetaill;
            }
        }



        // $eventPostId = 2844;

        // Fetch multiple polls, with their options and user poll data count
        $polls = EventPostPoll::with('event_poll_option')
            ->withCount('user_poll_data')
            ->where(['event_id' => $event])
            ->get();

        // dd($polls);
        // Check if polls exist
        // if ($polls->isEmpty()) {
        //     return response()->json(['message' => 'Polls not found'], 404);
        // }

        $pollsData = [];



        foreach ($polls as $poll) {
            // Get the poll duration and check if it is expired for each poll
            $pollDuration = getLeftPollTime($poll->updated_at, $poll->poll_duration);
            $isExpired = ($pollDuration == "");

            $pollData = [
                'poll_id' => $poll->id,
                'event_post_id' => $poll->event_post_id,
                'poll_question' => $poll->poll_question,
                'total_poll_duration' => $poll->poll_duration,
                'poll_duration_left' => $pollDuration,
                'is_expired' => $isExpired,
                'total_poll_vote' => $poll->user_poll_data_count,
                'poll_options' => [],
            ];

            // Loop through each poll's options and calculate vote percentages
            foreach ($poll->event_poll_option as $option) {
                $totalVotes = getOptionAllTotalVote($poll->id);
                $optionTotalVotes = getOptionTotalVote($option->id);

                $pollData['poll_options'][] = [
                    'id' => $option->id,
                    'option' => $option->option,
                    'total_vote_percentage' => $totalVotes > 0
                        ? round(($optionTotalVotes / $totalVotes) * 100) . '%'
                        : '0%',
                    'is_poll_selected' => checkUserGivePoll($user, $poll->id, $option->id), // This should return true/false based on whether the user has voted for this option
                ];
            }

            // Add the poll data to the polls data array
            $pollsData[] = $pollData;
        }
        $wallData['owner_stories'] = [];

        $eventLoginUserStoriesList = EventUserStory::with(['user', 'user_event_story' => function ($query) use ($currentDateTime) {
            $query->where('created_at', '>', now()->subHours(24));
        }])
            ->where(['event_id' => $event, 'user_id' => $user->id])
            ->where('created_at', '>', now()->subHours(24))
            ->first();

        if ($eventLoginUserStoriesList != null) {
            $storiesDetaill['id'] =  $eventLoginUserStoriesList->id;
            $storiesDetaill['user_id'] =  $eventLoginUserStoriesList->user->id;
            $storiesDetaill['username'] =  $eventLoginUserStoriesList->user->firstname . ' ' . $eventLoginUserStoriesList->user->lastname;
            $storiesDetaill['profile'] =  empty($eventLoginUserStoriesList->user->profile) ? "" : asset('storage/profile/' . $eventLoginUserStoriesList->user->profile);
            $storiesDetaill['story'] = [];
            foreach ($eventLoginUserStoriesList->user_event_story as $storyVal) {
                $storiesData['id'] = $storyVal->id;
                $storiesData['storyurl'] = empty($storyVal->story) ? "" : asset('storage/event_user_stories/' . $storyVal->story);
                $storiesData['type'] = $storyVal->type;
                $storiesData['post_time'] =  $this->setpostTime($storyVal->updated_at);
                $checkISeen = UserSeenStory::where(['user_id' => $user->id, 'user_event_story_id' => $storyVal->id])->count();
                $storiesData['is_seen'] = ($checkISeen != 0) ? "1" : "0";
                if ($storyVal->type == 'video') {
                    $storiesData['video_duration'] = (!empty($storyVal->duration)) ? $storyVal->duration : "";
                }
                $storiesData['created_at'] = $storyVal->updated_at;
                $storiesDetaill['story'][] = $storiesData;
            }
            $wallData['owner_stories'][] = $storiesDetaill;
        }
///postlist
        $eventCreator = Event::where('id', $event)->first();
        $eventPostList = EventPost::query();
        $eventPostList->with(['user', 'post_image'])
            ->withCount([
                'event_post_comment' => function ($query) {
                    $query->where('parent_comment_id', NULL);
                },
                'event_post_reaction'
            ])
            ->where([
                'event_id' => $event,
                'is_in_photo_moudle' => '1'
            ])
            ->whereDoesntHave('post_control', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('post_control', 'hide_post');
            });
            // dd($eventPostList);
        $checkEventOwner = Event::where(['id' => $event, 'user_id' => $user->id])->first();
        if ($checkEventOwner == null) {
            $eventPostList->where(function ($query) use ($user, $event) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('event.event_invited_user', function ($subQuery) use ($user, $event) {
                        $subQuery->whereHas('user', function ($userQuery) {
                            $userQuery->where('app_user', '1');
                        })
                            ->where('event_id', $event)
                            ->where('user_id', $user->id)
                            ->where(function ($privacyQuery) {
                                $privacyQuery->where(function ($q) {
                                    $q->where('rsvp_d', '1')
                                        ->where('rsvp_status', '1')
                                        ->where('post_privacy', '2');
                                })
                                    ->orWhere(function ($q) {
                                        $q->where('rsvp_d', '1')
                                            ->where('rsvp_status', '0')
                                            ->where('post_privacy', '3');
                                    })
                                    ->orWhere(function ($q) {
                                        $q->where('rsvp_d', '0')
                                            ->where('post_privacy', '4');
                                    })
                                    ->orWhere(function ($q) {
                                        $q->where('post_privacy', '1');
                                    });
                            });
                    });
            });
        }
        // dd($eventPostList);
        $eventPostList->orderBy('id', 'DESC')->get();

        // $totalPostWalls = $eventPostList->count();
        // $results = $eventPostList->paginate(10);
        // $total_page_of_eventPosts = ceil($totalPostWalls / $this->perPage);
        $postList = [];

        if (!empty($checkEventOwner)) {
            // if (count($results) != 0) {
                if ($eventPostList != "") {
                foreach ($eventPostList as  $value) {
                    $checkUserRsvp = checkUserAttendOrNot($value->event_id, $value->user->id);
                    $ischeckEventOwner = Event::where(['id' => $event, 'user_id' => $user->id])->first();
                    $postControl = PostControl::where(['user_id' => $user->id, 'event_id' => $event, 'event_post_id' => $value->id])->first();
                    // dd($postControl);
                    $count_kids_adult = EventInvitedUser::where(['event_id' => $event, 'user_id' => $value->user->id])
                        ->select('kids', 'adults', 'event_id', 'rsvp_status', 'user_id')
                        ->first();
                    if ($postControl != null) {
                        if ($postControl->post_control == 'hide_post') {
                            continue;
                        }
                    }
                    $checkUserIsReaction = EventPostReaction::where(['event_id' => $event, 'event_post_id' => $value->id, 'user_id' => $user->id])->first();

                    if (isset($value->post_type) && $value->post_type == '4' && $value->post_message != '') {
                        $EventPostMessageData = json_decode($value->post_message, true);
                        $rsvpstatus = (isset($value->post_type) && $value->post_type == '4' && $value->post_message != '') ? $value->post_message : $checkUserRsvp;
                        $kids = '0';
                        $adults = '0';
                        if (isset($EventPostMessageData['status'])) {
                            $rsvpstatus = (int)$EventPostMessageData['status'];
                        }
                        if (isset($EventPostMessageData['kids'])) {
                            $kids = (int)$EventPostMessageData["kids"];
                        }
                        if (isset($EventPostMessageData['adults'])) {
                            $adults = (int)$EventPostMessageData["adults"];
                        }
                    } else {
                        $kids = isset($count_kids_adult['kids']) ? $count_kids_adult['kids'] : 0;
                        $rsvpstatus = (isset($value->post_type) && $value->post_type == '4' && $value->post_message != '') ? $value->post_message : $checkUserRsvp;
                        $adults = isset($count_kids_adult['adults']) ? $count_kids_adult['adults'] : 0;
                    }
                    $postsNormalDetail['id'] =  $value->id;
                    $postsNormalDetail['user_id'] =  $value->user->id;
                    $postsNormalDetail['is_host'] =  ($value->user->id == $user->id) ? 1 : 0;
                    $postsNormalDetail['username'] =  $value->user->firstname . ' ' . $value->user->lastname;
                    $postsNormalDetail['profile'] =  empty($value->user->profile) ? "" : asset('storage/profile/' . $value->user->profile);
                    $postsNormalDetail['post_message'] = (empty($value->post_message) || $value->post_type == '4') ? "" :  $value->post_message;
                    $postsNormalDetail['rsvp_status'] = (string)$rsvpstatus ?? "";
                    $postsNormalDetail['kids'] = (int)$kids;
                    $postsNormalDetail['adults'] = (int)$adults;
                    $postsNormalDetail['location'] = $value->user->city != "" ? trim($value->user->city) . ($value->user->state != "" ? ', ' . $value->user->state : '') : "";
                    $postsNormalDetail['post_type'] = $value->post_type;
                    $postsNormalDetail['post_privacy'] = $value->post_privacy;
                    $postsNormalDetail['created_at'] = $value->created_at;
                    $postsNormalDetail['posttime'] = setpostTime($value->created_at);
                    $postsNormalDetail['commenting_on_off'] = $value->commenting_on_off;
                    $postsNormalDetail['post_image'] = [];
                    $totalEvent =  Event::where('user_id', $value->user->id)->count();
                    $totalEventPhotos =  EventPost::where(['user_id' => $value->user->id, 'post_type' => '1'])->count();
                    $comments =  EventPostComment::where('user_id', $value->user->id)->count();
                    $postsNormalDetail['user_profile'] = [
                        'id' => $value->user->id,
                        'profile' => empty($value->user->profile) ? "" : asset('storage/profile/' . $value->user->profile),
                        'bg_profile' => empty($value->user->bg_profile) ? "" : asset('storage/bg_profile/' . $value->user->bg_profile),
                        'gender' => ($value->user->gender != NULL) ? $value->user->gender : "",
                        'username' => $value->user->firstname . ' ' . $value->user->lastname,
                        'location' => ($value->user->city != NULL) ? $value->user->city : "",
                        'about_me' => ($value->user->about_me != NULL) ? $value->user->about_me : "",
                        'created_at' => empty($value->user->created_at) ? "" :   str_replace(' ', ', ', date('F Y', strtotime($value->user->created_at))),
                        'total_events' => $totalEvent,
                        'visible' => $value->user->visible,
                        'total_photos' => $totalEventPhotos,
                        'comments' => $comments,
                        'message_privacy' => $value->user->message_privacy
                    ];

                    if ($value->post_type == '1' && !empty($value->post_image)) {
                        foreach ($value->post_image as $imgVal) {
                            $postMedia = [
                                'id' => $imgVal->id,
                                'media_url' => asset('storage/post_image/' . $imgVal->post_image),
                                'type' => $imgVal->type,
                                'thumbnail' => (isset($imgVal->thumbnail) && $imgVal->thumbnail != null) ?  asset('storage/thumbnails/' . $imgVal->thumbnail) : '',
                            ];
                            if ($imgVal->type == 'video' && isset($imgVal->duration) && $imgVal->duration !== "") {
                                $postMedia['video_duration'] = $imgVal->duration;
                            } else {
                                unset($postMedia['video_duration']);
                            }
                            $postsNormalDetail['post_image'][] = $postMedia;
                        }
                    }
                    $postsNormalDetail['total_poll_vote'] = 0;
                    $postsNormalDetail['poll_duration'] = "";
                    $postsNormalDetail['is_expired'] = false;
                    $postsNormalDetail['poll_id'] = 0;
                    $postsNormalDetail['poll_question'] = "";
                    $postsNormalDetail['poll_option'] = [];
                    if ($value->post_type == '2') {
                        // Poll
                        $polls = EventPostPoll::with('event_poll_option')->withCount('user_poll_data')->where(['event_id' => $event, 'event_post_id' => $value->id])->first();
                        $postsNormalDetail['total_poll_vote'] = $polls->user_poll_data_count;
                        $pollDura = getLeftPollTime($polls->updated_at, $polls->poll_duration);
                        $postsNormalDetail['poll_duration'] = $pollDura;
                        $leftDay = (int) preg_replace('/[^0-9]/', '', $polls->poll_duration);
                        $postsNormalDetail['is_expired'] =  ($pollDura == "") ? true : false;
                        $postsNormalDetail['poll_id'] = $polls->id;
                        $postsNormalDetail['poll_question'] = $polls->poll_question;
                        $postsNormalDetail['total_poll_duration'] = $polls->poll_duration;

                        foreach ($polls->event_poll_option as $optionValue) {
                            $optionData['id'] = $optionValue->id;
                            $optionData['option'] = $optionValue->option;
                            $optionData['total_vote'] =  "0%";
                            if (getOptionAllTotalVote($polls->id) != 0) {
                                $optionData['total_vote'] =  round(getOptionTotalVote($optionValue->id) / getOptionAllTotalVote($polls->id) * 100) . "%";
                            }
                            $optionData['is_poll_selected'] = checkUserGivePoll($user->id, $polls->id, $optionValue->id);
                            $postsNormalDetail['poll_option'][] = $optionData;
                        }
                    }
                    $postsNormalDetail['post_recording'] = empty($value->post_recording) ? "" : asset('storage/event_post_recording/' . $value->post_recording);
                    $reactionList = getOnlyReaction($value->id);
                    $postsNormalDetail['reactionList'] = $reactionList;
                    $postsNormalDetail['total_comment'] = $value->event_post_comment_count;
                    $postsNormalDetail['total_likes'] = $value->event_post_reaction_count;
                    $postsNormalDetail['is_reaction'] = ($checkUserIsReaction != NULL) ? '1' : '0';
                    $postsNormalDetail['self_reaction'] = ($checkUserIsReaction != NULL) ? $checkUserIsReaction->reaction : "";
                    $postsNormalDetail['is_owner_post'] = ($value->user->id == $user->id) ? 1 : 0;
                    $postsNormalDetail['is_mute'] =  0;
                    if ($postControl != null) {
                        if ($postControl->post_control == 'mute') {
                            $postsNormalDetail['is_mute'] =  1;
                        }
                    }
                    $postList[] = $postsNormalDetail;
                }
                // dd($postList);
            }
        }

        $eventDetail = Event::with(['user', 'event_image', 'event_schedule', 'event_settings' => function ($query) {
            $query->select('event_id', 'podluck', 'allow_limit', 'adult_only_party');
        },'event_invited_user' => function ($query) {
            $query->where('is_co_host', '0')->with('user');
        }])->where('id', $event)->first();
        $guestView = [];
        $eventDetails['id'] = $eventDetail->id;
        $eventDetails['event_images'] = [];
        if (count($eventDetail->event_image) != 0) {
            foreach ($eventDetail->event_image as $values) {
                $eventDetails['event_images'][] = asset('storage/event_images/' . $values->image);
            }
        }
        $eventDetails['user_profile'] = empty($eventDetail->user->profile) ? "" : asset('storage/profile/' . $eventDetail->user->profile);
        $eventDetails['event_name'] = $eventDetail->event_name;
        $eventDetails['hosted_by'] = $eventDetail->hosted_by;
        $eventDetails['is_host'] = ($eventDetail->user_id == $user->id) ? 1 : 0;
        $eventDetails['podluck'] = $eventDetail->event_settings->podluck ?? "";

        $eventDetails['allow_limit'] = $eventDetail->event_settings->allow_limit ?? 0;
        $eventDetails['adult_only_party'] = $eventDetail->event_settings->adult_only_party ?? 0;
        $eventDetails['event_date'] = $eventDetail->start_date;
        $eventDetails['event_time'] = $eventDetail->rsvp_start_time;
        // if ($eventDetail->event_schedule->isNotEmpty()) {

        //     $eventDetails['event_time'] = $eventDetail->event_schedule->first()->start_time . ' to ' . $eventDetail->event_schedule->last()->end_time;
        // }
        $eventDetails['rsvp_by'] = (!empty($eventDetail->rsvp_by_date) || $eventDetail->rsvp_by_date != NULL) ? $eventDetail->rsvp_by_date : date('Y-m-d', strtotime($eventDetail->created_at));
        $current_date = date('Y-m-d');
        $eventDate = $eventDetail->start_date;
        $datetime1 = Carbon::parse($eventDate);
        $datetime2 =  Carbon::parse($current_date);
        $till_days = strval($datetime1->diff($datetime2)->days);

        if ($eventDate >= $current_date) {
            if ($till_days == 0) {
                $till_days = "Today";
            }
            if ($till_days == 1) {
                $till_days = "Tomorrow";
            }
        } else {
            $eventEndDate = $eventDetail->end_date;
            $till_days = "On going";
            if ($eventEndDate < $current_date) {
                $till_days = "Past";
            }
        }
        $eventDetail['is_past'] = ($eventDetail->end_date < date('Y-m-d')) ? true : false;
        $eventDetails['days_till_event'] = $till_days;
        $eventDetails['event_created_timestamp'] = Carbon::parse($eventDate)->timestamp;
        $eventDetails['message_to_guests'] = $eventDetail->message_to_guests;

        $coHosts = [];
        foreach ($eventDetail->event_invited_user as $hostValues) {
            $coHostDetail['id'] = $hostValues->user_id;
            $coHostDetail['profile'] = (empty($hostValues->user->profile) || $hostValues->user->profile == NULL) ? "" : asset('storage/profile/' . $hostValues->user->profile);
            $coHostDetail['name'] = $hostValues->user->firstname . ' ' . $hostValues->user->lastname;
            $coHostDetail['email'] = (empty($hostValues->user->email) || $hostValues->user->email == NULL) ? "" : $hostValues->user->email;
            $coHostDetail['phone_number'] = (empty($hostValues->user->phone_number) || $hostValues->user->phone_number == NULL) ? "" : $hostValues->user->phone_number;
            $coHosts[] = $coHostDetail;
        }
        $eventDetails['co_hosts'] = $coHosts;
        $eventDetails['event_location_name'] = $eventDetail->event_location_name;
        $eventDetails['address_1'] = $eventDetail->address_1;
        $eventDetails['address_2'] = $eventDetail->address_2;
        $eventDetails['state'] = $eventDetail->state;
        $eventDetails['zip_code'] = $eventDetail->zip_code;
        $eventDetails['city'] = $eventDetail->city;
        $eventDetails['latitude'] = (!empty($eventDetail->latitude) || $eventDetail->latitude != null) ? $eventDetail->latitude : "";
        $eventDetails['logitude'] = (!empty($eventDetail->logitude) || $eventDetail->logitude != null) ? $eventDetail->logitude : "";

        $eventsScheduleList = [];
        foreach ($eventDetail->event_schedule as $key => $value) {
            $event_name =  $value->activity_title;
            if ($value->type == '1') {
                $event_name = "Start Event";
            } elseif ($value->type == '3') {
                $event_name = "End Event";
            }
            $scheduleDetail['id'] = $value->id;
            $scheduleDetail['activity_title'] = $event_name;
            $scheduleDetail['start_time'] = ($value->start_time != null) ? $value->start_time : "";
            $scheduleDetail['end_time'] = ($value->end_time != null) ? $value->end_time : "";
            $scheduleDetail['type'] = $value->type;
            $eventsScheduleList[] = $scheduleDetail;
        }
        $eventDetails['event_schedule'] = $eventsScheduleList;

        $eventDetails['gift_registry'] = [];
        if (!empty($eventDetail->gift_registry_id)) {
            $giftregistry = explode(',', $eventDetail->gift_registry_id);
            $giftregistryData = EventGiftRegistry::whereIn('id', $giftregistry)->get();
            foreach ($giftregistryData as $value) {
                $giftRegistryDetail['id'] = $value->id;
                $giftRegistryDetail['registry_recipient_name'] = $value->registry_recipient_name;
                $giftRegistryDetail['registry_link'] = $value->registry_link;
                $eventDetails['gift_registry'][] = $giftRegistryDetail;
            }
        }
        $eventDetails['event_detail'] = "";
        if ($eventDetail->event_settings) {
            $eventData = [];
            if ($eventDetail->event_settings->allow_for_1_more == '1') {
                $eventData[] = "Can Bring Guests ( limit " . $eventDetail->event_settings->allow_limit . ")";
            }
            if ($eventDetail->event_settings->adult_only_party == '1') {
                $eventData[] = "Adults Only";
            }
            if ($eventDetail->rsvp_by_date_set == '1') {
                $eventData[] = date('F d, Y', strtotime($eventDetail->rsvp_by_date));
            }
            if ($eventDetail->event_settings->podluck == '1') {
                $eventData[] = "Event Potluck";
            }
            if ($eventDetail->event_settings->gift_registry == '1') {
                $eventData[] = "Gift Registry";
            }
            if ($eventDetail->event_settings->events_schedule == '1') {
                $eventData[] = "Event has Schedule";
            }
            if ($eventDetail->start_date != $eventDetail->end_date) {
                $eventData[] = "Multiple Day Event";
            }
            if (!empty($eventData)) {
                $eventData[] = date('F d, Y', strtotime($eventDetail->start_date));
                $numberOfGuest = EventInvitedUser::where('event_id', $eventDetail->id)->count();
                $guestData = EventInvitedUser::with('user') // Eager load the related 'user' model
                    ->where('event_id', $eventDetail->id)
                    // ->where('user_id', '!=', $user->id)
                    ->get();

                $eventData[] = "Number of guests : " . $numberOfGuest;
                $eventData['guests'] = $guestData;
            }
            $eventDetails['event_detail'] = $eventData;
        }
        $eventDetails['total_limit'] = $eventDetail->event_settings->allow_limit ?? 0;
        $eventInfo['guest_view'] = $eventDetails;
        $totalEnvitedUser = EventInvitedUser::whereHas('user', function ($query) {

            $query->where('app_user', '1');
        })->where(['event_id' => $eventDetail->id])->count();

        $eventattending = EventInvitedUser::whereHas('user', function ($query) {

            $query->where('app_user', '1');
        })->where(['rsvp_status' => '1', 'event_id' => $eventDetail->id])->count();

        $eventNotComing = EventInvitedUser::whereHas('user', function ($query) {

            $query->where('app_user', '1');
        })->where(['rsvp_d' => '1', 'rsvp_status' => '0', 'event_id' => $eventDetail->id])->count();



        $todayrsvprate = EventInvitedUser::whereHas('user', function ($query) {

            $query->where('app_user', '1');
        })->where(['rsvp_status' => '1', 'event_id' => $eventDetail->id])

            ->whereDate('created_at', '=', date('Y-m-d'))

            ->count();



        $pendingUser = EventInvitedUser::whereHas('user', function ($query) {

            $query->where('app_user', '1');
        })->where(['event_id' => $eventDetail->id, 'rsvp_d' => '0'])->count();



        $adults = EventInvitedUser::whereHas('user', function ($query) {

            $query->where('app_user', '1');
        })->where(['event_id' => $eventDetail->id, 'rsvp_status' => '1'])->sum('adults');

        $kids = EventInvitedUser::whereHas('user', function ($query) {

            $query->where('app_user', '1');
        })->where(['event_id' => $eventDetail->id, 'rsvp_status' => '1'])->sum('kids');


        $eventAboutHost['attending'] = $adults + $kids;



        $eventAboutHost['adults'] = (int)$adults;

        $eventAboutHost['kids'] = (int)$kids;



        $eventAboutHost['not_attending'] = $eventNotComing;

        $eventAboutHost['pending'] = $pendingUser;

        $eventAboutHost['comment'] = EventPostComment::where(['event_id' => $eventDetail->id, 'user_id' => $user->id])->count();
        $total_photos = EventPostImage::where(['event_id' => $eventDetail->id])->count();

        $eventAboutHost['photo_uploaded'] = $total_photos;

        $eventAboutHost['total_invite'] =  count(getEventInvitedUser($event));

        $eventAboutHost['invite_view_rate'] = EventInvitedUser::whereHas('user', function ($query) {

            $query->where('app_user', '1');
        })->where(['event_id' => $eventDetail->id, 'read' => '1'])->count();

        $invite_view_percent = 0;
        if ($totalEnvitedUser != 0) {

            $invite_view_percent = EventInvitedUser::whereHas('user', function ($query) {

                $query->where('app_user', '1');
            })->where(['event_id' => $eventDetail->id, 'read' => '1'])->count() / $totalEnvitedUser * 100;
        }

        $eventAboutHost['invite_view_percent'] = round($invite_view_percent, 2) . "%";

        $today_invite_view_percent = 0;
        if ($totalEnvitedUser != 0) {
            $today_invite_view_percent =   EventInvitedUser::whereHas('user', function ($query) {

                $query->where('app_user', '1');
            })->where(['event_id' => $eventDetail->id, 'read' => '1', 'event_view_date' => date('Y-m-d')])->count() / $totalEnvitedUser * 100;
        }

        $eventAboutHost['today_invite_view_percent'] = round($today_invite_view_percent, 2)  . "%";

        $eventAboutHost['rsvp_rate'] = $eventattending;

        $eventAboutHost['rsvp_rate_percent'] = ($totalEnvitedUser != 0) ? $eventattending / $totalEnvitedUser * 100 . "%" : 0 . "%";

        $eventAboutHost['today_upstick'] = ($totalEnvitedUser != 0) ? $todayrsvprate / $totalEnvitedUser * 100 . "%" : 0 . "%";

        $eventInfo['host_view'] = $eventAboutHost;
        $rsvpSent = EventInvitedUser::whereHas('user', function ($query) {
            $query->where('app_user', '1');
        })->where(['user_id' => $user->id, 'event_id' => $event])->first();
        $current_page = "wall";

        // return $wallData;
        return view('layout', compact(
            'title',
            'page',
            'users',
            'event',
            'eventInfo',
            'eventDetails',
            'storiesList',
            'pollsData',
            'wallData',
            'postList',
            'encrypt_event_id',
            'current_page',
            'eventDetails',
            'rsvpSent'


        ));

        try {
            $page = "1";
            // $page = (isset($input['page'])) ? $input['page'] : "1";
            $this->eventViewUser($user->id, $event_id);
            $currentDateTime = Carbon::now();
            $wallData = [];
            $wallData['owner_stories'] = [];

            $eventLoginUserStoriesList = EventUserStory::with(['user', 'user_event_story' => function ($query) use ($currentDateTime) {
                $query->where('created_at', '>', now()->subHours(24));
            }])
                ->where(['event_id' => $event_id, 'user_id' => $user->id])
                ->where('created_at', '>', now()->subHours(24))
                ->first();

            if ($eventLoginUserStoriesList != null) {
                $storiesDetaill['id'] =  $eventLoginUserStoriesList->id;
                $storiesDetaill['user_id'] =  $eventLoginUserStoriesList->user->id;
                $storiesDetaill['username'] =  $eventLoginUserStoriesList->user->firstname . ' ' . $eventLoginUserStoriesList->user->lastname;
                $storiesDetaill['profile'] =  empty($eventLoginUserStoriesList->user->profile) ? "" : asset('storage/profile/' . $eventLoginUserStoriesList->user->profile);
                $storiesDetaill['story'] = [];
                foreach ($eventLoginUserStoriesList->user_event_story as $storyVal) {
                    $storiesData['id'] = $storyVal->id;
                    $storiesData['storyurl'] = empty($storyVal->story) ? "" : asset('storage/event_user_stories/' . $storyVal->story);
                    $storiesData['type'] = $storyVal->type;
                    $storiesData['post_time'] =  $this->setpostTime($storyVal->updated_at);
                    $checkISeen = UserSeenStory::where(['user_id' => $user->id, 'user_event_story_id' => $storyVal->id])->count();
                    $storiesData['is_seen'] = ($checkISeen != 0) ? "1" : "0";
                    if ($storyVal->type == 'video') {
                        $storiesData['video_duration'] = (!empty($storyVal->duration)) ? $storyVal->duration : "";
                    }
                    $storiesData['created_at'] = $storyVal->updated_at;
                    $storiesDetaill['story'][] = $storiesData;
                }
                $wallData['owner_stories'][] = $storiesDetaill;
            }

            $totalStories =  EventUserStory::with(['user', 'user_event_story' => function ($query) use ($currentDateTime) {
                $query->where('created_at', '>', now()->subHours(24));
            }])
                ->where('event_id', $event_id)
                ->where('created_at', '>', now()->subHours(24))
                ->where('user_id', '!=', $user->id)->count();

            // if (isset($input['type']) && ($input['type'] == '1' || $input['type'] == '0')) {

            //     $total_page_of_stories = ceil($totalStories / $this->perPage);
            //     $eventStoriesList = EventUserStory::with(['user', 'user_event_story' => function ($query) use ($currentDateTime) {
            //         $query->where('created_at', '>', now()->subHours(24));
            //     }])
            //         ->where('created_at', '>', now()->subHours(24))
            //         ->where('event_id', $event_id)
            //         ->where('user_id', '!=', $user->id)
            //         ->paginate($this->perPage, ['*'], 'page', $page);
            // } else {
            $total_page_of_stories = ceil($totalStories / $this->perPage);
            $eventStoriesList = EventUserStory::with(['user', 'user_event_story' => function ($query) use ($currentDateTime) {
                $query->where('created_at', '>', now()->subHours(24));
            }])
                ->where('created_at', '>', now()->subHours(24))
                ->where('event_id', $event_id)
                ->where('user_id', '!=', $user->id)->paginate($this->perPage, ['*'], 'page', "1");
            // }
            $storiesList = [];
            if (count($eventStoriesList) != 0) {
                foreach ($eventStoriesList as $value) {
                    $storiesDetaill['id'] =  $value->id;
                    $storiesDetaill['user_id'] =  $value->user->id;
                    $storiesDetaill['username'] =  $value->user->firstname . ' ' . $value->user->lastname;
                    $storiesDetaill['profile'] =  empty($value->user->profile) ? "" : asset('storage/profile/' . $value->user->profile);
                    $storyAlldata = [];
                    foreach ($value->user_event_story as $storyVal) {
                        $storiesData['id'] = $storyVal->id;
                        $storiesData['storyurl'] = empty($storyVal->story) ? "" : asset('storage/event_user_stories/' . $storyVal->story);
                        $storiesData['type'] = $storyVal->type;
                        $storiesData['post_time'] =  $this->setpostTime($storyVal->created_at);
                        $checkISeen = UserSeenStory::where(['user_id' => $user->id, 'user_event_story_id' => $storyVal->id])->count();
                        $storiesData['is_seen'] = ($checkISeen != 0) ? "1" : "0";
                        if ($storyVal->type == 'video') {
                            $storiesData['video_duration'] = (!empty($storyVal->duration)) ? $storyVal->duration : "";
                        }
                        $storiesData['created_at'] =  $storyVal->created_at;
                        $storyAlldata[] = $storiesData;
                    }
                    $storiesDetaill['story'] = $storyAlldata;
                    $storiesList[] = $storiesDetaill;
                }
            }
            //  Posts List //
            // $selectedFilters = $request->input('filters');
            $eventCreator = Event::where('id', $event_id)->first();
            $eventPostList = EventPost::query();
            $eventPostList->with(['user', 'post_image'])
                ->withCount([
                    'event_post_comment' => function ($query) {
                        $query->where('parent_comment_id', NULL);
                    },
                    'event_post_reaction'
                ])
                ->where([
                    'event_id' => $event_id,
                    'is_in_photo_moudle' => '0'
                ])
                ->whereDoesntHave('post_control', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('post_control', 'hide_post');
                });
            $checkEventOwner = Event::where(['id' => $event_id, 'user_id' => $user->id])->first();
            if ($checkEventOwner == null) {
                $eventPostList->where(function ($query) use ($user, $event_id) {
                    $query->where('user_id', $user->id)
                        ->orWhereHas('event.event_invited_user', function ($subQuery) use ($user, $event_id) {
                            $subQuery->whereHas('user', function ($userQuery) {
                                $userQuery->where('app_user', '1');
                            })
                                ->where('event_id', $event_id)
                                ->where('user_id', $user->id)
                                ->where(function ($privacyQuery) {
                                    $privacyQuery->where(function ($q) {
                                        $q->where('rsvp_d', '1')
                                            ->where('rsvp_status', '1')
                                            ->where('post_privacy', '2');
                                    })
                                        ->orWhere(function ($q) {
                                            $q->where('rsvp_d', '1')
                                                ->where('rsvp_status', '0')
                                                ->where('post_privacy', '3');
                                        })
                                        ->orWhere(function ($q) {
                                            $q->where('rsvp_d', '0')
                                                ->where('post_privacy', '4');
                                        })
                                        ->orWhere(function ($q) {
                                            $q->where('post_privacy', '1');
                                        });
                                });
                        });
                });
            }
            $eventPostList->orderBy('id', 'DESC');
            // if (!empty($selectedFilters) && !in_array('all', $selectedFilters)) {
            //     $eventPostList->where(function ($query) use ($selectedFilters, $eventCreator) {
            //         foreach ($selectedFilters as $filter) {
            //             switch ($filter) {
            //                 case 'host_update':
            //                     $query->orWhere('user_id', $eventCreator->user_id);
            //                     break;
            //                 case 'video_uploads':
            //                     $query->orWhere(function ($qury) {
            //                         $qury->where('post_type', '1')
            //                             ->whereHas('post_image', function ($q) {
            //                                 $q->where('type', 'video');
            //                             });
            //                     });
            //                     break;
            //                 case 'photo_uploads':
            //                     $query->orWhere(function ($qury) {
            //                         $qury->where('post_type', '1')
            //                             ->whereHas('post_image', function ($q) {
            //                                 $q->where('type', 'image');
            //                             });
            //                     });
            //                     break;
            //                 case 'polls':
            //                     $query->orWhere('post_type', '2');
            //                     break;
            //                 case 'comments':
            //                     $query->orWhere('post_type', '0');
            //                     break;
            //                     // Add more cases for other filters if needed
            //             }
            //         }
            //     });
            // }

            $totalPostWalls = $eventPostList->count();
            $results = $eventPostList->paginate($this->perPage, ['*'], 'page', $page);
            $total_page_of_eventPosts = ceil($totalPostWalls / $this->perPage);
            $postList = [];
            // dd($eventPostList);
            if (!empty($checkEventOwner)) {
                if (count($results) != 0) {
                    foreach ($results as  $value) {
                        $checkUserRsvp = checkUserAttendOrNot($value->event_id, $value->user->id);
                        $ischeckEventOwner = Event::where(['id' => $event_id, 'user_id' => $user->id])->first();
                        $postControl = PostControl::where(['user_id' => $user->id, 'event_id' => $event_id, 'event_post_id' => $value->id])->first();
                        $count_kids_adult = EventInvitedUser::where(['event_id' => $event_id, 'user_id' => $value->user->id])
                            ->select('kids', 'adults', 'event_id', 'rsvp_status', 'user_id')
                            ->first();
                        if ($postControl != null) {
                            if ($postControl->post_control == 'hide_post') {
                                continue;
                            }
                        }
                        $checkUserIsReaction = EventPostReaction::where(['event_id' => $event_id, 'event_post_id' => $value->id, 'user_id' => $user->id])->first();

                        if (isset($value->post_type) && $value->post_type == '4' && $value->post_message != '') {
                            $EventPostMessageData = json_decode($value->post_message, true);
                            $rsvpstatus = (isset($value->post_type) && $value->post_type == '4' && $value->post_message != '') ? $value->post_message : $checkUserRsvp;
                            $kids = '0';
                            $adults = '0';
                            if (isset($EventPostMessageData['status'])) {
                                $rsvpstatus = (int)$EventPostMessageData['status'];
                            }
                            if (isset($EventPostMessageData['kids'])) {
                                $kids = (int)$EventPostMessageData["kids"];
                            }
                            if (isset($EventPostMessageData['adults'])) {
                                $adults = (int)$EventPostMessageData["adults"];
                            }
                        } else {
                            $kids = isset($count_kids_adult['kids']) ? $count_kids_adult['kids'] : 0;
                            $rsvpstatus = (isset($value->post_type) && $value->post_type == '4' && $value->post_message != '') ? $value->post_message : $checkUserRsvp;
                            $adults = isset($count_kids_adult['adults']) ? $count_kids_adult['adults'] : 0;
                        }
                        $postsNormalDetail['id'] =  $value->id;
                        $postsNormalDetail['user_id'] =  $value->user->id;
                        $postsNormalDetail['is_host'] =  ($value->user->id == $user->id) ? 1 : 0;
                        $postsNormalDetail['username'] =  $value->user->firstname . ' ' . $value->user->lastname;
                        $postsNormalDetail['profile'] =  empty($value->user->profile) ? "" : asset('storage/profile/' . $value->user->profile);
                        $postsNormalDetail['post_message'] = (empty($value->post_message) || $value->post_type == '4') ? "" :  $value->post_message;
                        $postsNormalDetail['rsvp_status'] = (string)$rsvpstatus;
                        $postsNormalDetail['kids'] = (int)$kids;
                        $postsNormalDetail['adults'] = (int)$adults;
                        $postsNormalDetail['location'] = $value->user->city != "" ? trim($value->user->city) . ($value->user->state != "" ? ', ' . $value->user->state : '') : "";
                        $postsNormalDetail['post_type'] = $value->post_type;
                        $postsNormalDetail['post_privacy'] = $value->post_privacy;
                        $postsNormalDetail['created_at'] = $value->created_at;
                        $postsNormalDetail['posttime'] = setpostTime($value->created_at);
                        $postsNormalDetail['commenting_on_off'] = $value->commenting_on_off;
                        $postsNormalDetail['post_image'] = [];
                        $totalEvent =  Event::where('user_id', $value->user->id)->count();
                        $totalEventPhotos =  EventPost::where(['user_id' => $value->user->id, 'post_type' => '1'])->count();
                        $comments =  EventPostComment::where('user_id', $value->user->id)->count();
                        $postsNormalDetail['user_profile'] = [
                            'id' => $value->user->id,
                            'profile' => empty($value->user->profile) ? "" : asset('storage/profile/' . $value->user->profile),
                            'bg_profile' => empty($value->user->bg_profile) ? "" : asset('storage/bg_profile/' . $value->user->bg_profile),
                            'gender' => ($value->user->gender != NULL) ? $value->user->gender : "",
                            'username' => $value->user->firstname . ' ' . $value->user->lastname,
                            'location' => ($value->user->city != NULL) ? $value->user->city : "",
                            'about_me' => ($value->user->about_me != NULL) ? $value->user->about_me : "",
                            'created_at' => empty($value->user->created_at) ? "" :   str_replace(' ', ', ', date('F Y', strtotime($value->user->created_at))),
                            'total_events' => $totalEvent,
                            'visible' => $value->user->visible,
                            'total_photos' => $totalEventPhotos,
                            'comments' => $comments,
                            'message_privacy' => $value->user->message_privacy
                        ];

                        if ($value->post_type == '1' && !empty($value->post_image)) {
                            foreach ($value->post_image as $imgVal) {
                                $postMedia = [
                                    'id' => $imgVal->id,
                                    'media_url' => asset('storage/post_image/' . $imgVal->post_image),
                                    'type' => $imgVal->type,
                                    'thumbnail' => (isset($imgVal->thumbnail) && $imgVal->thumbnail != null) ?  asset('storage/thumbnails/' . $imgVal->thumbnail) : '',
                                ];
                                if ($imgVal->type == 'video' && isset($imgVal->duration) && $imgVal->duration !== "") {
                                    $postMedia['video_duration'] = $imgVal->duration;
                                } else {
                                    unset($postMedia['video_duration']);
                                }
                                $postsNormalDetail['post_image'][] = $postMedia;
                            }
                        }
                        $postsNormalDetail['total_poll_vote'] = 0;
                        $postsNormalDetail['poll_duration'] = "";
                        $postsNormalDetail['is_expired'] = false;
                        $postsNormalDetail['poll_id'] = 0;
                        $postsNormalDetail['poll_question'] = "";
                        $postsNormalDetail['poll_option'] = [];
                        if ($value->post_type == '2') {
                            // Poll
                            $polls = EventPostPoll::with('event_poll_option')->withCount('user_poll_data')->where(['event_id' => $event_id, 'event_post_id' => $value->id])->first();
                            $postsNormalDetail['total_poll_vote'] = $polls->user_poll_data_count;
                            $pollDura = getLeftPollTime($polls->updated_at, $polls->poll_duration);
                            $postsNormalDetail['poll_duration'] = $pollDura;
                            $leftDay = (int) preg_replace('/[^0-9]/', '', $polls->poll_duration);
                            $postsNormalDetail['is_expired'] =  ($pollDura == "") ? true : false;
                            $postsNormalDetail['poll_id'] = $polls->id;
                            $postsNormalDetail['poll_question'] = $polls->poll_question;
                            $postsNormalDetail['total_poll_duration'] = $polls->poll_duration;

                            foreach ($polls->event_poll_option as $optionValue) {
                                $optionData['id'] = $optionValue->id;
                                $optionData['option'] = $optionValue->option;
                                $optionData['total_vote'] =  "0%";
                                if (getOptionAllTotalVote($polls->id) != 0) {
                                    $optionData['total_vote'] =  round(getOptionTotalVote($optionValue->id) / getOptionAllTotalVote($polls->id) * 100) . "%";
                                }
                                $optionData['is_poll_selected'] = checkUserGivePoll($user->id, $polls->id, $optionValue->id);
                                $postsNormalDetail['poll_option'][] = $optionData;
                            }
                        }
                        $postsNormalDetail['post_recording'] = empty($value->post_recording) ? "" : asset('storage/event_post_recording/' . $value->post_recording);
                        $reactionList = getOnlyReaction($value->id);
                        $postsNormalDetail['reactionList'] = $reactionList;
                        $postsNormalDetail['total_comment'] = $value->event_post_comment_count;
                        $postsNormalDetail['total_likes'] = $value->event_post_reaction_count;
                        $postsNormalDetail['is_reaction'] = ($checkUserIsReaction != NULL) ? '1' : '0';
                        $postsNormalDetail['self_reaction'] = ($checkUserIsReaction != NULL) ? $checkUserIsReaction->reaction : "";
                        $postsNormalDetail['is_owner_post'] = ($value->user->id == $user->id) ? 1 : 0;
                        $postsNormalDetail['is_mute'] =  0;
                        if ($postControl != null) {
                            if ($postControl->post_control == 'mute') {
                                $postsNormalDetail['is_mute'] =  1;
                            }
                        }
                        $postList[] = $postsNormalDetail;
                    }
                }
            } else {
                if (count($results) != 0) {
                    foreach ($results as $value) {

                        $checkUserRsvp = checkUserAttendOrNot($value->event_id, $value->user->id);
                        $count_kids_adult = EventInvitedUser::where(['event_id' => $event_id, 'user_id' => $value->user->id])
                            ->select('kids', 'adults', 'event_id', 'rsvp_status', 'user_id')
                            ->first();
                        $ischeckEventOwner = Event::where(['id' => $event_id, 'user_id' => $value->user->id])->first();
                        $postControl = PostControl::where(['user_id' => $user->id, 'event_id' => $event_id, 'event_post_id' => $value->id])->first();
                        $checkUserIsReaction = EventPostReaction::where(['event_id' => $event_id, 'event_post_id' => $value->id, 'user_id' => $user->id])->first();

                        // if ($value->post_privacy == '1') {
                        // $EventPostMessageData = [];
                        if (isset($value->post_type) && $value->post_type == '4' && $value->post_message != '') {
                            $EventPostMessageData = json_decode($value->post_message, true);
                            $rsvpstatus = (isset($value->post_type) && $value->post_type == '4' && $value->post_message != '') ? $value->post_message : $checkUserRsvp;
                            $kids = '0';
                            $adults = '0';
                            if (isset($EventPostMessageData['status'])) {
                                $rsvpstatus = (string)$EventPostMessageData['status'];
                            }
                            if (isset($EventPostMessageData['kids'])) {
                                $kids = (int)$EventPostMessageData["kids"];
                            }
                            if (isset($EventPostMessageData['adults'])) {
                                $adults = (int)$EventPostMessageData["adults"];
                            }
                        } else {
                            $kids = isset($count_kids_adult['kids']) ? $count_kids_adult['kids'] : 0;
                            $rsvpstatus = (isset($value->post_type) && $value->post_type == '4' && $value->post_message != '') ? $value->post_message : $checkUserRsvp;
                            $adults = isset($count_kids_adult['adults']) ? $count_kids_adult['adults'] : 0;
                        }
                        $postsNormalDetail['id'] =  $value->id;
                        $postsNormalDetail['user_id'] =  $value->user->id;
                        $postsNormalDetail['username'] =  $value->user->firstname . ' ' . $value->user->lastname;
                        $postsNormalDetail['profile'] =  empty($value->user->profile) ? "" : asset('storage/profile/' . $value->user->profile);
                        $postsNormalDetail['is_host'] =  ($ischeckEventOwner != null) ? 1 : 0;
                        $postsNormalDetail['post_message'] = (empty($value->post_message) || $value->post_type == '4') ? "" :  $value->post_message;
                        $postsNormalDetail['rsvp_status'] = (string)$rsvpstatus;
                        $postsNormalDetail['kids'] = (int)$kids;
                        $postsNormalDetail['adults'] = (int)$adults;
                        $postsNormalDetail['location'] = ($value->user->city != NULL) ? $value->user->city : "";
                        $postsNormalDetail['commenting_on_off'] = $value->commenting_on_off;
                        $postsNormalDetail['post_type'] = $value->post_type;
                        $postsNormalDetail['post_privacy'] = $value->post_privacy;
                        $postsNormalDetail['created_at'] = $value->created_at;
                        $postsNormalDetail['posttime'] = setpostTime($value->created_at);
                        $postsNormalDetail['post_image'] = [];
                        $totalEvent =  Event::where('user_id', $value->user->id)->count();
                        $totalEventPhotos =  EventPost::where(['user_id' => $value->user->id, 'post_type' => '1'])->count();
                        $comments =  EventPostComment::where('user_id', $value->user->id)->count();

                        $postsNormalDetail['user_profile'] = [
                            'id' => $value->user->id,
                            'profile' => empty($value->user->profile) ? "" : asset('storage/profile/' . $value->user->profile),
                            'bg_profile' => empty($value->user->bg_profile) ? "" : asset('storage/bg_profile/' . $value->user->bg_profile),
                            'gender' => ($value->user->gender != NULL) ? $value->user->gender : "",
                            'username' => $value->user->firstname . ' ' . $value->user->lastname,
                            'location' => ($value->user->city != NULL) ? $value->user->city : "",
                            'about_me' => ($value->user->about_me != NULL) ? $value->user->about_me : "",
                            'created_at' => empty($value->user->created_at) ? "" :   str_replace(' ', ', ', date('F Y', strtotime($value->user->created_at))),
                            'total_events' => $totalEvent,
                            'visible' => $value->user->visible,
                            'total_photos' => $totalEventPhotos,
                            'comments' => $comments,
                            'message_privacy' => $value->user->message_privacy
                        ];
                        if ($value->post_type == '1' && !empty($value->post_image)) {
                            foreach ($value->post_image as $imgVal) {
                                $postMedia = [
                                    'id' => $imgVal->id,
                                    'media_url' => asset('storage/post_image/' . $imgVal->post_image),
                                    'type' => $imgVal->type,
                                    'thumbnail' => (isset($imgVal->thumbnail) && $imgVal->thumbnail != null) ?  asset('storage/thumbnails/' . $imgVal->thumbnail) : '',
                                ];
                                if ($imgVal->type == 'video' && isset($imgVal->duration) && $imgVal->duration !== "") {
                                    $postMedia['video_duration'] = $imgVal->duration;
                                } else {
                                    unset($postMedia['video_duration']);
                                }
                                $postsNormalDetail['post_image'][] = $postMedia;
                            }
                        }
                        $postsNormalDetail['total_poll_vote'] = 0;
                        $postsNormalDetail['poll_duration'] = "";
                        $postsNormalDetail['is_expired'] = false;
                        $postsNormalDetail['poll_id'] = 0;
                        $postsNormalDetail['poll_question'] = "";
                        $postsNormalDetail['poll_option'] = [];
                        if ($value->post_type == '2') { // Poll
                            $polls = EventPostPoll::with('event_poll_option')->withCount('user_poll_data')->where(['event_id' => $event_id, 'event_post_id' => $value->id])->first();
                            $postsNormalDetail['total_poll_vote'] = $polls->user_poll_data_count;
                            $pollDura = getLeftPollTime($polls->updated_at, $polls->poll_duration);
                            $postsNormalDetail['poll_duration'] = $pollDura;
                            // $postsNormalDetail['poll_duration'] =  empty($polls->poll_duration) ? "" :  $polls->poll_duration;
                            $leftDay = (int) preg_replace('/[^0-9]/', '', $polls->poll_duration);
                            $postsNormalDetail['is_expired'] =  ($pollDura == "") ? true : false;
                            $postsNormalDetail['poll_id'] = $polls->id;
                            $postsNormalDetail['poll_question'] = $polls->poll_question;
                            $postsNormalDetail['total_poll_duration'] = $polls->poll_duration;
                            foreach ($polls->event_poll_option as $optionValue) {
                                $optionData['id'] = $optionValue->id;
                                $optionData['option'] = $optionValue->option;
                                $optionData['total_vote'] = "0%";
                                if (getOptionAllTotalVote($polls->id) != 0) {
                                    $optionData['total_vote'] =   round(getOptionTotalVote($optionValue->id) / getOptionAllTotalVote($polls->id) * 100) . "%";
                                }
                                $optionData['is_poll_selected'] = checkUserGivePoll($user->id, $polls->id, $optionValue->id);
                                $postsNormalDetail['poll_option'][] = $optionData;
                            }
                        }
                        $postsNormalDetail['post_recording'] = empty($value->post_recording) ? "" : asset('storage/event_post_recording/' . $value->post_recording);
                        $reactionList = getOnlyReaction($value->id);
                        $postsNormalDetail['reactionList'] = $reactionList;
                        $postsNormalDetail['total_comment'] = $value->event_post_comment_count;
                        $postsNormalDetail['total_likes'] = $value->event_post_reaction_count;
                        $postsNormalDetail['is_reaction'] = ($checkUserIsReaction != NULL) ? '1' : '0';
                        $postsNormalDetail['self_reaction'] = ($checkUserIsReaction != NULL) ? $checkUserIsReaction->reaction : "";
                        $postsNormalDetail['is_owner_post'] = ($value->user->id == $user->id) ? 1 : 0;
                        $postsNormalDetail['is_mute'] =  0;
                        if ($postControl != null) {
                            if ($postControl->post_control == 'mute') {
                                $postsNormalDetail['is_mute'] =  1;
                            }
                        }
                        $postList[] = $postsNormalDetail;
                    }
                }
            }
            $userrsvp_status = EventInvitedUser::where(['user_id' => $user->id, 'event_id' => $event_id])->pluck('rsvp_status')->first();
            $rsvp_status = (isset($userrsvp_status) && $userrsvp_status != "") ? $userrsvp_status : "";
            $wallData['stories'] = $storiesList;
            $wallData['posts'] = $postList;
            $filename = 'event_wall_response.txt';
            $commentnumber = json_encode(['status' => 1, 'rsvp_status' => $rsvp_status, 'total_page_of_stories' => $total_page_of_stories, 'total_page_of_eventPosts' => $total_page_of_eventPosts, 'data' => $wallData, 'message' => "Event wall data"]);
            Storage::append($filename, $commentnumber);







            // return compact('rsvp_status','total_page_of_stories','total_page_of_eventPosts','wallData');
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => "db error"]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => "something went wrong"]);
        }
    }

    public function createPost(Request $request)
    {
        // dd($request);
        $user  = Auth::guard('api')->user();
        $input = $request->all();
        // $validator = Validator::make($input, [
        //     'event_id' => ['required', 'exists:events,id'],
        //     'post_privacy' => ['required', 'in:1,2,3,4'],
        //     'post_type' => ['required', 'in:0,1,2,3'],
        //     'commenting_on_off' => ['required', 'in:0,1'],
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 0,
        //         'message' => $validator->errors()->first(),
        //     ]);
        // }
        // try {
        DB::beginTransaction();
        $creatEventPost = new EventPost;
        $creatEventPost->event_id = $request->event_id;
        $creatEventPost->user_id = $user->id;
        $creatEventPost->post_message = $request->post_message;

        if ($request->hasFile('post_recording')) {
            $record = $request->post_recording;
            $recordingName = time() . '_' . $record->getClientOriginalName();
            $record->move(public_path('storage/event_post_recording'), $recordingName);
            $creatEventPost->post_recording = $recordingName;
        }
        $creatEventPost->post_privacy = $request->post_privacys;
        $creatEventPost->post_type = $request->post_type;
        $creatEventPost->commenting_on_off = $request->commenting_on_off;
        $creatEventPost->is_in_photo_moudle = $request->is_in_photo_moudle;
        $creatEventPost->save();
        $video = 0;
        $image = 0;
        if ($creatEventPost->id) {
            if ($request->post_type == '1') {
                if (!empty($request->post_image)) {
                    $postimages = $request->post_image;
                    foreach ($postimages as $key => $postImgValue) {
                        $postImage = $postImgValue;
                        $imageName = time() . $key . '_' . $postImage->getClientOriginalName();
                        $checkIsimageOrVideo = checkIsimageOrVideo($postImage);
                        $duration = "";
                        $thumbName = "";
                        if ($checkIsimageOrVideo == 'video') {
                            $duration = getVideoDuration($postImage);
                            if (isset($request->thumbnail) && $request->thumbnail != Null) {
                                $thumbimage = $request->thumbnail[$key];
                                $thumbName = time() . $key . '_' . $thumbimage->getClientOriginalName();
                                // $checkIsimageOrVideo = checkIsimageOrVideo($thumbimage);
                                $thumbimage->move(public_path('storage/thumbnails'), $thumbName);
                            }
                            if (file_exists(public_path('storage/post_image/') . $imageName)) {
                                $imagePath = public_path('storage/post_image/') . $imageName;
                                unlink($imagePath);
                            }
                            $postImage->move(public_path('storage/post_image'), $imageName);
                        } else {

                            $temporaryThumbnailPath = public_path('storage/post_image/') . 'tmp_' . $imageName;
                            Image::load($postImgValue->getRealPath())
                                ->width(500)
                                ->optimize()
                                ->save($temporaryThumbnailPath);
                            $destinationPath = public_path('storage/post_image/');
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
                            rename($temporaryThumbnailPath, $destinationPath . $imageName);
                        }
                        if ($checkIsimageOrVideo == 'video') {
                            $video++;
                        } else {
                            $image++;
                        }
                        $eventPostImage = new EventPostImage();
                        $eventPostImage->event_id = $request->event_id;
                        $eventPostImage->event_post_id = $creatEventPost->id;
                        $eventPostImage->post_image = $imageName;
                        $eventPostImage->duration = $duration;
                        $eventPostImage->type = $checkIsimageOrVideo;
                        $eventPostImage->thumbnail = $thumbName;
                        $eventPostImage->save();
                    }
                }
            }

            if ($request->post_type == '2') {
                $eventPostPoll = new EventPostPoll;
                $eventPostPoll->event_id = $request->event_id;
                $eventPostPoll->event_post_id = $creatEventPost->id;
                $eventPostPoll->poll_question = $request->poll_question;
                $eventPostPoll->poll_duration = $request->poll_duration;
                if ($eventPostPoll->save()) {
                    $option = json_decode($request->option);
                    foreach ($option as $value) {
                        $pollOption = new EventPostPollOption;
                        $pollOption->event_post_poll_id = $eventPostPoll->id;
                        $pollOption->option = $value;
                        $pollOption->save();
                    }
                }
            }
            $notificationParam = [
                'sender_id' => $user->id,
                'event_id' => $request->event_id,
                'post_id' => $creatEventPost->id,
                'is_in_photo_moudle' => $request->is_in_photo_moudle,
                'post_type' => $request->post_type,
                'post_privacy' => $request->post_privacy,
                'video' => $video,
                'image' => $image
            ];
        }

        DB::commit();

        if ($request->is_in_photo_moudle == '1') {
            sendNotification('photos', $notificationParam);
        } else {
            sendNotification('upload_post', $notificationParam);
        }
        return response()->json(['status' => 1, 'message' => "Post is created sucessfully"]);
    }

    public function eventViewUser($user_id, $event_id)
    {
        $checkViewbyuser = EventInvitedUser::whereHas('user', function ($query) {
            $query->where('app_user', '1');
        })->where(['user_id' => $user_id, 'event_id' => $event_id])->first();
        if ($checkViewbyuser != null) {
            if ($checkViewbyuser->read == '0') {
                $checkViewbyuser->read = '1';
                $checkViewbyuser->event_view_date = date('Y-m-d');
                $checkViewbyuser->save();
                DB::commit();
                return response()->json(['status' => 1, 'message' => "viewed invite"]);
            }
        }
    }

    public function setpostTime($dateTime)
    {

        $commentDateTime = $dateTime; // Replace this with your actual timestamp

        // Convert the timestamp to a Carbon instance
        $commentTime = Carbon::parse($commentDateTime);

        // Calculate the time difference
        $timeAgo = $commentTime->diffForHumans(); // This will give the time ago format


        // Display the time ago
        return $timeAgo;
    }
    public function createStory(Request $request)
    {
        // dd($request);
        $user = Auth::guard('web')->user()->id;

        $event_id = $request->eventId;
        $storyNames = $request->file('story'); // Get the file names from the request



        try {

            DB::beginTransaction();
            $checkAlreadyStories = EventUserStory::where(['event_id' => $event_id, 'user_id' => $user])->first();

            $createStory = $checkAlreadyStories;

            if ($checkAlreadyStories == null) {


                // $createStory =  EventUserStory::create([
                //     'event_id' => $event_id,
                //     'user_id' => $user,
                // ]);
                $createStory = new EventUserStory();
                $createStory->event_id = $event_id;
                $createStory->user_id = $user;

                // Save the data
                $createStory->save();
            }
            if ($createStory) {
                if (!empty($request->file('story'))) {

                    $createStory->created_at = Carbon::now();
                    $createStory->save();

                    $storyData = $request->file('story');

                    foreach ($storyData as $postStoryValue) {
                        $postStory = $postStoryValue;
                        $imageName = time() . '_' . $postStory->getClientOriginalName();
                        $checkIsimageOrVideo = checkIsimageOrVideo($postStory);
                        $duration = '0';
                        if ($checkIsimageOrVideo == 'video') {
                            $duration = getVideoDuration($postStory);

                            // if (file_exists(public_path('storage/event_user_stories/') . $imageName)) {

                            //     $imagePath = public_path('storage/event_user_stories/') . $imageName;
                            //     unlink($imagePath);
                            // }


                            $postStory->move(public_path('storage/event_user_stories'), $imageName);
                        } else {
                            $postStory->move(public_path('storage/event_user_stories'), $imageName);
                        }

                        $storyId = $createStory->id;
                        $storylestest =   UserEventStory::create([
                            'event_story_id' => $storyId,
                            'story' => $imageName,
                            'duration' => $duration,
                            'type' => $checkIsimageOrVideo
                        ]);
                    }
                    DB::commit();
                    $currentDateTime = Carbon::now();

                    $getStoryData =   EventUserStory::with(['user', 'user_event_story' => function ($query) use ($currentDateTime) {
                        $query->where('created_at', '>', $currentDateTime->subHours(24));
                    }])->where(['event_id' => $event_id, 'user_id' => $user])->where('created_at', '>', $currentDateTime->subHours(24))->first();

                    $storiesDeta['owner_stories'] = [];
                    if ($getStoryData != null) {

                        $storiesDetail['id'] =  $getStoryData->id;
                        $storiesDetail['user_id'] =  $getStoryData->user->id;

                        $storiesDetail['username'] =  $getStoryData->user->firstname . ' ' . $getStoryData->user->lastname;

                        $storiesDetail['profile'] =  empty($getStoryData->user->profile) ? "" : asset('storage/profile/' . $getStoryData->user->profile);

                        $storiesDetail['story'] = [];
                        foreach ($getStoryData->user_event_story as $storyVal) {
                            $storiesData['id'] = $storyVal->id;
                            $storiesData['storyurl'] = empty($storyVal->story) ? "" : asset('storage/event_user_stories/' . $storyVal->story);
                            $storiesData['type'] = $storyVal->type;

                            if ($storyVal->type == 'video') {
                                $storiesData['video_duration'] = (!empty($storyVal->duration)) ? $storyVal->duration : "";
                            }
                            $storiesData['post_time'] =  $this->setpostTime($storyVal->created_at);
                            $storiesData['created_at'] =  $storyVal->created_at;
                            $storiesDetail['story'][] = $storiesData;
                        }
                        $storiesDeta['owner_stories'][] = $storiesDetail;
                    }

                    return response()->json(['status' => 1, 'message' => "Event story uploaded successfully", 'data' => $storiesDeta]);
                }
            } else {
                return response()->json(['status' => 0, 'message' => "Event story not uploaded"]);
            }
        } catch (QueryException $e) {
            // dd($e);
            DB::rollBack();

            return response()->json(['status' => 0, 'message' => "db error"]);
        }
    }


    public function fetchUserStories(Request $request, $eventId)
    {
        $user = Auth::guard('web')->user();
        $event_id = $eventId;
        $storyType = $request->query('storyType');

        try {
            $currentDateTime = Carbon::now();

            // Initialize response structure
            $storiesDeta = [
                'owner_stories' => [],
            ];

            $otherdata = [
                'other_stories' => [],
            ];
            // Fetch the authenticated user's stories
            $getStoryData = EventUserStory::with(['user', 'user_event_story' => function ($query) use ($currentDateTime) {
                $query->where('created_at', '>', now()->subHours(24));
            }])
                ->where('event_id', $event_id)
                ->where('user_id', $user->id)
                ->where('created_at', '>', now()->subHours(24))
                ->first();

            // Process owner's stories
            if ($getStoryData != null) {
                $storiesDetail = [
                    'id' => $getStoryData->id,
                    'user_id' => $getStoryData->user->id,
                    'username' => $getStoryData->user->firstname . ' ' . $getStoryData->user->lastname,
                    'profile' => empty($getStoryData->user->profile) ? "" : asset('storage/profile/' . $getStoryData->user->profile),
                    'story' => [],
                ];

                foreach ($getStoryData->user_event_story as $storyVal) {
                    $storiesData = [
                        'id' => $storyVal->id,
                        'storyurl' => empty($storyVal->story) ? "" : asset('storage/event_user_stories/' . $storyVal->story),
                        'type' => $storyVal->type,
                        'post_time' => $this->setpostTime($storyVal->created_at),
                        'created_at' => $storyVal->created_at,
                    ];

                    if ($storyVal->type == 'video') {
                        $storiesData['video_duration'] = !empty($storyVal->duration) ? $storyVal->duration : "";
                    }

                    $storiesDetail['story'][] = $storiesData;
                }

                $storiesDeta['owner_stories'][] = $storiesDetail;
            }

            // Fetch other users' stories
            $otherStories = EventUserStory::with(['user', 'user_event_story' => function ($query) use ($currentDateTime) {
                $query->where('created_at', '>', now()->subHours(24));
            }])
                ->where('event_id', $event_id)
                ->where('user_id', '!=', $user->id)
                ->where('created_at', '>', now()->subHours(24))
                ->get();

            foreach ($otherStories as $value) {
                $storiesDetaill = [
                    'id' => $value->id,
                    'user_id' => $value->user->id,
                    'username' => $value->user->firstname . ' ' . $value->user->lastname,
                    'profile' => empty($value->user->profile) ? "" : asset('storage/profile/' . $value->user->profile),
                    'story' => [],
                ];

                foreach ($value->user_event_story as $storyVal) {
                    $storiesData = [
                        'id' => $storyVal->id,
                        'storyurl' => empty($storyVal->story) ? "" : asset('storage/event_user_stories/' . $storyVal->story),
                        'type' => $storyVal->type,
                        'post_time' => $this->setpostTime($storyVal->created_at),
                        'is_seen' => UserSeenStory::where(['user_id' => $user->id, 'user_event_story_id' => $storyVal->id])->exists() ? "1" : "0",
                        'created_at' => $storyVal->created_at,
                    ];

                    if ($storyVal->type == 'video') {
                        $storiesData['video_duration'] = !empty($storyVal->duration) ? $storyVal->duration : "";
                    }

                    $storiesDetaill['story'][] = $storiesData;
                }

                $otherdata['other_stories'][] = $storiesDetaill;
            }
            if ($storyType == "owner") {
                return response()->json(['status' => 1, 'message' => "Stories fetched successfully", 'data' => $storiesDeta]);
            } else {
                return response()->json(['status' => 1, 'message' => "Stories fetched successfully", 'data' => $otherdata]);
            }
        } catch (QueryException $e) {
            return response()->json(['status' => 0, 'message' => "Error fetching stories"]);
        }
    }

    public function createPoll(Request $request)
    {

        // Validate the request
        $request->validate([
            'question' => 'required|string|max:255',
            'duration' => 'required|string',
            'options' => 'required|array|min:2', // Ensure at least two options are provided
            'options.*' => 'required|string|max:100', // Validate each option
        ]);

        $user = Auth::guard('web')->user()->id;
        $creatEventPost = new EventPost;
        $creatEventPost->event_id = $request->event_id;
        $creatEventPost->user_id = $user;
        $creatEventPost->post_message = $request->input('content');

        if ($request->hasFile('post_recording')) {
            $record = $request->post_recording;
            $recordingName = time() . '_' . $record->getClientOriginalName();
            $record->move(public_path('storage/event_post_recording'), $recordingName);
            $creatEventPost->post_recording = $recordingName;
        }
        $creatEventPost->post_privacy = $request->post_privacys;
        $creatEventPost->post_type = "2";
        $creatEventPost->commenting_on_off = $request->commenting_on_off;
        $creatEventPost->is_in_photo_moudle = "0";
        $creatEventPost->save();
        // Create the poll
        $eventPostPoll = new EventPostPoll;
        $eventPostPoll->event_id = $request->event_id; // Example event ID
        $eventPostPoll->event_post_id =  $creatEventPost->id; // Example post ID
        $eventPostPoll->poll_question = $request->question;
        $eventPostPoll->poll_duration = $request->duration;

        if ($eventPostPoll->save()) {
            // Save poll options
            foreach ($request->options as $value) {
                $pollOption = new EventPostPollOption();
                $pollOption->event_post_poll_id = $eventPostPoll->id;
                $pollOption->option = $value;
                $pollOption->save();
            }
        }

        return redirect()->back()->with('success', 'Poll created successfully!');
    }





    public function VoteOfPoll(Request $request)
    {
        $pollId = $request->input('poll_id');
        $optionId = $request->input('option_id');
        $userId = Auth::guard('web')->user()->id;

        // Fetch the poll to validate its expiration status
        $poll = EventPostPoll::find($pollId);

        if (!$poll) {
            return response()->json(['success' => false, 'message' => 'Poll not found.'], 404);
        }

        // Check if the poll is expired
        $pollDuration = getLeftPollTime($poll->updated_at, $poll->poll_duration);
        if ($pollDuration === "") { // Assuming "" means expired in `getLeftPollTime`
            return response()->json([
                'success' => false,
                'message' => 'This poll has expired. Votes cannot be updated.',
            ]);
        }

        // Check if the user has already voted
        $existingVote = UserEventPollData::where('event_post_poll_id', $pollId)
            ->where('user_id', $userId)
            ->first();

        if ($existingVote) {
            // If the user has already voted, update the existing vote
            $existingVote->event_poll_option_id = $optionId;
            $existingVote->save();

            // Recalculate the poll data
            $updatedPoll = $this->getPollData($request)->getData();

            return response()->json([
                'success' => true,
                'message' => 'Vote updated successfully.',
                'poll_data' => $updatedPoll,
            ]);
        } else {
            // If the user hasn't voted yet, record the new vote
            UserEventPollData::create([
                'event_post_poll_id' => $pollId,
                'event_poll_option_id' => $optionId,
                'user_id' => $userId,
            ]);

            // Recalculate the poll data
            $updatedPoll = $this->getPollData($request)->getData();

            return response()->json([
                'success' => true,
                'message' => 'Vote submitted successfully.',
                'poll_data' => $updatedPoll,
            ]);
        }
    }


    public function GetPollData(Request $request)
    {
        //   dd($request);
        // $validator = Validator::make($request->all(), [
        //     'event_id' => 'required|integer',
        //     'event_post_id' => 'required|integer',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 422);
        // }
        //  dd($request);
        $eventId = (int)$request->input('eventId');
        $eventPostId = (int)$request->input('eventPostId');


        // dd($eventId,$eventPostId);
        // Fetch multiple polls, with their options and user poll data count
        $polls = EventPostPoll::with('event_poll_option')
            ->withCount('user_poll_data')
            ->where(['event_id' => $eventId, 'event_post_id' => $eventPostId])
            ->get();

        // dd($polls);
        // Check if polls exist
        if ($polls->isEmpty()) {
            return response()->json(['message' => 'Polls not found'], 404);
        }

        $pollsData = [];

        $userId = Auth::guard('web')->user()->id;

        foreach ($polls as $poll) {
            // Get the poll duration and check if it is expired for each poll
            $pollDuration = getLeftPollTime($poll->updated_at, $poll->poll_duration);
            $isExpired = ($pollDuration == "");

            $pollData = [
                'poll_id' => $poll->id,
                'poll_question' => $poll->poll_question,
                'total_poll_duration' => $poll->poll_duration,
                'poll_duration_left' => $pollDuration,
                'is_expired' => $isExpired,
                'total_poll_vote' => $poll->user_poll_data_count,
                'poll_options' => [],
            ];

            // Loop through each poll's options and calculate vote percentages
            foreach ($poll->event_poll_option as $option) {
                $totalVotes = getOptionAllTotalVote($poll->id);
                $optionTotalVotes = getOptionTotalVote($option->id);

                $pollData['poll_options'][] = [
                    'id' => $option->id,
                    'option' => $option->option,
                    'total_vote_percentage' => $totalVotes > 0
                        ? round(($optionTotalVotes / $totalVotes) * 100) . '%'
                        : '0%',
                    'is_poll_selected' => checkUserGivePoll($userId, $poll->id, $option->id), // This should return true/false based on whether the user has voted for this option
                ];
            }

            // Add the poll data to the polls data array
            $pollsData[] = $pollData;
        }

        return response()->json($pollsData);
    }
    public function createEventPost(Request $request)
    {

        $user = Auth::guard('web')->user()->id;

        // Create new event post
        $createEventPost = new EventPost();
        $createEventPost->event_id = $request->event_id;
        $createEventPost->user_id = $user;
        $createEventPost->post_message = $request->input('content'); // Placeholder, update as necessary
        $createEventPost->post_privacy = $request->input('post_privacys'); // Example: public post
        $createEventPost->post_type = "1"; // Define post type
        $createEventPost->commenting_on_off = $request->input('commenting_on_off'); // Comments allowed
        $createEventPost->is_in_photo_moudle = "1"; // Whether the post contains photos
        $createEventPost->save();

        // Check if files were uploaded
        if ($createEventPost->id && $request->hasFile('files')) {
            $postFiles = $request->file('files'); // Get the uploaded files
            $imageUrls = [];
            $videoCount = 0;
            $imageCount = 0;

            foreach ($postFiles as $key => $postFile) {
                $fileName = time() . $key . '_' . $postFile->getClientOriginalName();
                $checkIsImageOrVideo = checkIsImageOrVideo($postFile); // Assuming this is a helper function
                $duration = "";
                $thumbName = "";

                // Process video
                if ($checkIsImageOrVideo == 'video') {
                    $duration = getVideoDuration($postFile); // Assuming this is a helper function
                    $thumbName = genrate_thumbnail($fileName, $createEventPost->id);
                    $postFile->move(public_path('storage/post_image'), $fileName);
                }
                //else {
                //     // Process image
                //     $temporaryThumbnailPath = public_path('storage/post_image/') . 'tmp_' . $fileName;
                //     Image::load($postFile->getRealPath())
                //         ->width(500)
                //         ->optimize()
                //         ->save($temporaryThumbnailPath);
                //     rename($temporaryThumbnailPath, public_path('storage/post_image/') . $fileName);
                // }

                // Count images and videos
                if ($checkIsImageOrVideo == 'video') {
                    $videoCount++;
                } else {
                    $imageCount++;
                }

                // Save post image
                $eventPostImage = new EventPostImage();
                $eventPostImage->event_id = $request->event_id;
                $eventPostImage->event_post_id = $createEventPost->id;
                $eventPostImage->post_image = $fileName;
                $eventPostImage->duration = $duration;
                $eventPostImage->type = $checkIsImageOrVideo;
                $eventPostImage->thumbnail = $thumbName;
                $eventPostImage->save();
            }

            return redirect()->back()->with('success', 'Event post uploded successfully!');
        }

        return redirect()->back()->with('success', 'Event Post created successfully!');
    }
}
