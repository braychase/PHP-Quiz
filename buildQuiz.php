<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $quizName = $_POST["quizName"];

    }

    $data = array();

    include 'ChromePhp.php';
    include 'FileUtils.php';

    $fileContents = readFileIntoString($quizName);
    $quiz = json_decode($fileContents, true); //true = array

    $_SESSION['full_quiz'] = $quiz;
    $title = $quiz["title"];
    $theQuestions = $quiz["questions"];

    $allQuestionsAnswered = true;

    $_SESSION['currentQuestionNumber'] = 0;

    $numberOfQuestions = count($theQuestions);

    if (isset($_SESSION['user_answers'])) {
        //if it's set, destroy it
        unset($_SESSION['user_answers']);
    }
    //set 'userAnswers' array with -1 values
    $userAnswers = array_fill(0, $numberOfQuestions, -1);

    $_SESSION['user_answers'] = $userAnswers;

    header("Location: showQuestion.php");
?>