<?php

namespace App\Http\Controllers;

use Auth;
use App\Channel;
use App\Discussion;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ForumsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $discussions = Discussion::orderBy('created_at', 'desc')->paginate(3);


        switch (request('filter')) {
            case 'me':
                $result = Discussion::where("user_id", Auth::id())->paginate(3);
                break;

            case "solved":
                $answered = [];

                foreach (Discussion::all() as $d) {

                    if ($d->hasBestAnswer()) {
                        array_push($answered, $d);
                    }
                }

                $result = new Paginator($answered, 3);

                break;

                case "unsolved":
                    $unanswered = [];

                    foreach (Discussion::all() as $d) {

                        if (!$d->hasBestAnswer()) {
                            array_push($unanswered, $d);
                        }
                    }

                    $result = new Paginator($unanswered, 3);

                    break;

            default:
                $result = Discussion::orderBy("created_at", "desc")->paginate(3);
                break;
        }

        return view('forum')->with('discussions', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function channel($slug)
    {
        $channel = Channel::where('slug', $slug)->first();

        return view('channel')->with('discussions', $channel->discussions()->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
