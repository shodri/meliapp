<?php

namespace App\Http\Controllers\Panel;

use App\Models\Answer;
use App\Models\Vehicle;
use App\Services\MeliService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Http\Requests\AnswerRequest;

use Carbon\Carbon;

class NotificationController extends Controller
{

    public function __construct(MeliService $meliService)
    {
        $this->middleware('auth')->except(['showProduct']);

        parent::__construct($meliService);
    }

    public function getNotificationsData(Request $request)
    {
        // For the sake of simplicity, assume we have a variable called
        // $notifications with the unread notifications. Each notification
        // have the next properties:
        // icon: An icon for the notification.
        // text: A text for the notification.
        // time: The time since notification was created on the server.
        // At next, we define a hardcoded variable with the explained format,
        // but you can assume this data comes from a database query.

        $vehicles = Vehicle::all();

        foreach($vehicles as $vehicle){
            $questions = $this->meliService->getQuestions($vehicle->meli_id);

            foreach($questions->questions as $question){
                Question::updateOrCreate(
                    ['id' => $question->id],
                    [
                        'date_created'  => Carbon::parse($question->date_created)->toDateTimeString(),
                        'item_id'       => $question->item_id,
                        'status'        => $question->status,
                        'text'          => $question->text,
                        'from'          => $question->from->id,
                    ]
                );

                if($question->status == 'ANSWERED'){
                    Answer::updateOrCreate(
                        ['text' => $question->answer->text],
                        [
                            'date_created'  => Carbon::parse($question->answer->date_created)->toDateTimeString(),
                            'question_id'   => $question->id,
                            'status'        => $question->answer->status,
                            'text'          => $question->answer->text,
                        ]
                    );
                }
            }
        }

        $questions = Question::where('status', 'UNANSWERED')->orderBy('updated_at','desc')->get();

        $currentTimestamp = now(); // Obtener la fecha y hora actual
        $questionTimestamp = $questions->first()->updated_at;
        $difference = $questionTimestamp->diffForHumans($currentTimestamp);

        $notifications = [
            [
                'icon' => 'fas fa-fw fa-envelope',
                'text' => $questions->count() . ' mensajes nuevos',
                'time' => $difference,
            ],
        ];
        // $notifications = [
        //     [
        //         'icon' => 'fas fa-fw fa-envelope',
        //         'text' => rand(0, 10) . ' new messages',
        //         'time' => rand(0, 10) . ' minutes',
        //     ],
        //     [
        //         'icon' => 'fas fa-fw fa-users text-primary',
        //         'text' => rand(0, 10) . ' friend requests',
        //         'time' => rand(0, 60) . ' minutes',
        //     ],
        //     [
        //         'icon' => 'fas fa-fw fa-file text-danger',
        //         'text' => rand(0, 10) . ' new reports',
        //         'time' => rand(0, 60) . ' minutes',
        //     ],
        // ];

        // Now, we create the notification dropdown main content.

        $dropdownHtml = '';

        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}'></i>";

            $time = "<span class='float-right text-muted text-sm'>
                    {$not['time']}
                    </span>";

            $dropdownHtml .= "<a href='#' class='dropdown-item'>
                                {$icon}{$not['text']}{$time}
                            </a>";

            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        // Return the new notification data.

        return [
            'label'       => count($notifications),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
            'dropdown'    => $dropdownHtml,
        ];
    }

    public function index()
    {
        $questions = Question::where('status', 'UNANSWERED')->orderBy('updated_at','desc')->get();

        foreach ($questions as $question) {
            $fecha = Carbon::parse($question->updated_at);
            $ahora = Carbon::now();
            $question->interval = $fecha->diffForHumans($ahora);
        }

        return view('notifications.index')->with([
            'questions' => $questions,
        ]);

    }

    public function question(Question $question)
    {
    //    dd($question);

        return view('notifications.answer')->with([
            'question' => $question,
            ]);
    }

    public function answer(AnswerRequest $request, Question $question)
    {
        $answer = $request->input('answer');
        dd($answer, $question);

        return view('notifications.answer')->with([
            'question' => $question,
            ]);
    }

}
