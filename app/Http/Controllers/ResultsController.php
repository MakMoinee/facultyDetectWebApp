<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (session()->exists("users")) {
            $id = $request->query("id");
            return view('loading', ['id' => $id]);
        } else {
            return redirect("/");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showResults(Request $request)
    {
        if (session()->exists("users")) {

            $id = $request->query("id");
            if ($id) {

                $queryResult = DB::table("vwresults")->where("facultyID", $id)->get();
                $results = json_decode($queryResult, true);
                $todo = $this->getToDos($results[0]['pregnancyStage']);
                $todoArr = explode("-", $todo);
                // $toDos = $this->getToDos();
                return view('results', ['results' => $results[0], 'todo' => $todoArr]);
            } else {
                return redirect("/");
            }
        } else {
            return redirect("/");
        }
    }

    public function getToDos(string $toDo): string
    {
        $result = "";

        if ($toDo == "Pre-pregnancy") {
            $result = "- Do ensure that your Shih Tzu is in good health before breeding.
            - Do consult with your veterinarian to ensure that your Shih Tzu is up to date on vaccinations and free from any health issues that could cause complications during pregnancy or delivery.
            - Do ensure that both the male and female Shih Tzu are healthy and not related to each other.
            - Don't breed your Shih Tzu if they are too young or too old.
            - Don't breed your Shih Tzu too frequently as this can lead to health problems.";
        } else if ($toDo == "Early pregnancy (1-4 weeks)") {
            $result = "- Do continue to feed your Shih Tzu a well-balanced, high-quality diet.
            - Do provide your Shih Tzu with a comfortable and warm place to rest.
            - Do take your Shih Tzu to the veterinarian for regular check-ups to monitor her health and the health of her puppies.
            - Don't give your Shih Tzu any medications or supplements without consulting with your veterinarian.
            - Don't allow your Shih Tzu to become overly active or engage in strenuous exercise.";
        } else if ($toDo == "Mid-pregnancy (4-6 weeks)") {
            $result = "- Do continue to provide your Shih Tzu with a nutritious and balanced diet.
            - Do prepare a comfortable and warm area for your Shih Tzu to give birth.
            - Do monitor your Shih Tzu closely for any signs of labor or complications.
            - Don't expose your Shih Tzu to any stressors or sudden changes in her environment.
            - Don't allow your Shih Tzu to engage in any strenuous activities.";
        } else if ($toDo == "Late pregnancy") {
            $result = "- Do monitor your Shih Tzu closely for any signs of labor or complications.
            - Do continue to provide your Shih Tzu with a nutritious and balanced diet.
            - Do prepare for the arrival of the puppies by having supplies ready such as blankets, towels, and a heat lamp.
            - Don't allow your Shih Tzu to become overly active or engage in strenuous exercise.
            - Don't interfere with the birthing process unless there are signs of complications.";
        } else if ($toDo == "Late pregnancy") {
            $result = "- Do monitor your Shih Tzu closely for any signs of labor or complications.
            - Do continue to provide your Shih Tzu with a nutritious and balanced diet.
            - Do prepare for the arrival of the puppies by having supplies ready such as blankets, towels, and a heat lamp.
            - Don't allow your Shih Tzu to become overly active or engage in strenuous exercise.
            - Don't interfere with the birthing process unless there are signs of complications.";
        }

        return $result;
    }
}
