<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Post('login', 'API\UserController@login');
Route::Post('register', 'API\UserController@register');
Route::Post('loginVerify', 'API\UserController@loginVerify');
Route::GET('geometries/output', [
    'as' => 'geometries.index',
    'uses' => 'API\GeometriesController@indexOutput'
]);
Route::GET('questions/{subsection}', [
    'as' => 'questions.indexSubSection',
    'uses' => 'API\QuestionsController@indexSubSection'
]);

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
    Route::post('verify', 'API\UserController@verify');

    #region sections
    Route::GET('sections', [
        'as' => 'sections.index',
        'uses' => 'API\SectionsController@index'
    ]);
    Route::GET('sections/{section}', [
        'as' => 'sections.show',
        'uses' => 'API\SectionsController@show'
    ]);
    /*
    Route::POST('sections', [
        'as' => 'sections.store',
        'uses' => 'API\SectionsController@store'
    ]);
    Route::PUT('sections/{section}', [
        'as' => 'sections.update',
        'uses' => 'API\SectionsController@update'
    ]);
    Route::DELETE('sections/{section}', [
        'as' => 'sections.destroy',
        'uses' => 'API\SectionsController@destroy'
    ]);
    */
    //Route::apiResource('sections', 'API\SectionsController');
    #endregion sections

    #region subsections
    Route::GET('subsections', [
        'as' => 'subsections.index',
        'uses' => 'API\SubSectionsController@index'
    ]);
    Route::GET('subsections/{subsection}', [
        'as' => 'subsections.show',
        'uses' => 'API\SubSectionsController@show'
    ]);
    /*
    Route::POST('subsections', [
        'as' => 'subsections.store',
        'uses' => 'API\SubSectionsController@store'
    ]);
    Route::PUT('subsections/{subsection}', [
        'as' => 'subsections.update',
        'uses' => 'API\SubSectionsController@update'
    ]);
    Route::DELETE('subsections/{subsection}', [
        'as' => 'subsections.destroy',
        'uses' => 'API\SubSectionsController@destroy'
    ]);
    */
    #endregion subsections

    #region surveys
    Route::GET('surveys', [
        'as' => 'surveys.index',
        'uses' => 'API\SurveysController@index'
    ]);
    Route::POST('surveys', [
        'as' => 'surveys.store',
        'uses' => 'API\SurveysController@store'
    ]);
    Route::GET('surveys/get/{survey}', [
        'as' => 'surveys.show',
        'uses' => 'API\SurveysController@show'
    ]);

    Route::GET('surveys/user', 'API\SurveysController@showwithid');

    Route::POST('surveys/submit', [
        'as' => 'surveys.submit',
        'uses' => 'API\SurveysController@submit'
    ]);

    Route::PUT('surveys/{survey}', [
        'as' => 'surveys.update',
        'uses' => 'API\SurveysController@update'
    ]);
    /*
    Route::DELETE('surveys/{survey}', [
        'as' => 'surveys.destroy',
        'uses' => 'API\SurveysController@destroy'
    ]);
    */
    #endregion surveys

    #region questions
    /*
    Route::POST('questions', [
        'as' => 'questions.store',
        'uses' => 'API\QuestionsController@store'
    ]);
    Route::GET('questions/{question}', [
        'as' => 'questions.show',
        'uses' => 'API\QuestionsController@show'
    ]);
    Route::PUT('questions/{question}', [
        'as' => 'questions.update',
        'uses' => 'API\QuestionsController@update'
    ]);
    Route::DELETE('questions/{question}', [
        'as' => 'questions.destroy',
        'uses' => 'API\QuestionsController@destroy'
    ]);
    */
    #endregion questions

    #region options
    Route::GET('options', [
        'as' => 'options.index',
        'uses' => 'API\OptionsController@index'
    ]);
    /*
    Route::POST('options', [
        'as' => 'options.store',
        'uses' => 'API\OptionsController@store'
    ]);
    Route::GET('options/{option}', [
        'as' => 'options.show',
        'uses' => 'API\OptionsController@show'
    ]);
    Route::PUT('options/{option}', [
        'as' => 'options.update',
        'uses' => 'API\OptionsController@update'
    ]);
    Route::DELETE('options/{option}', [
        'as' => 'options.destroy',
        'uses' => 'API\OptionsController@destroy'
    ]);
    */
    #endregion options

    #region answers
    Route::GET('answers', [
        'as' => 'answers.index',
        'uses' => 'API\AnswersController@index'
    ]);
    Route::POST('answers', [
        'as' => 'answers.store',
        'uses' => 'API\AnswersController@store'
    ]);
    Route::GET('answers/get/{answer}', [
        'as' => 'answers.show',
        'uses' => 'API\AnswersController@show'
    ]);
    Route::GET('answers/survey', [
        'as' => 'answers.showWithServey',
        'uses' => 'API\AnswersController@showWithSurvey'
    ]);
    Route::PUT('answers/{answer}', [
        'as' => 'answers.update',
        'uses' => 'API\AnswersController@update'
    ]);
    Route::DELETE('answers/{answer}', [
        'as' => 'answers.destroy',
        'uses' => 'API\AnswersController@destroy'
    ]);

    #endregion answers

    #region geometries

    Route::GET('geometries', [
        'as' => 'geometries.index',
        'uses' => 'API\GeometriesController@index'
    ]);

    Route::GET('geometries/survey', [
        'as' => 'geometries.index',
        'uses' => 'API\GeometriesController@indexWithSurvey'
    ]);

    Route::POST('geometries', [
        'as' => 'geometries.store',
        'uses' => 'API\GeometriesController@store'
    ]);

    Route::GET('geometries/get/{geometry}', [
        'as' => 'geometries.show',
        'uses' => 'API\GeometriesController@show'
    ]);

    Route::PUT('geometries/{geometry}', [
        'as' => 'geometries.update',
        'uses' => 'API\GeometriesController@update'
    ]);

    Route::PUT('geometries/{geometry}', [
        'as' => 'geometries.update',
        'uses' => 'API\GeometriesController@update'
    ]);

    Route::POST('geometries/updatebatch', [
        'as' => 'geometries.updateBatch',
        'uses' => 'API\GeometriesController@updateBatch'
    ]);

    Route::DELETE('geometries/{geometry}', [
        'as' => 'geometries.destroy',
        'uses' => 'API\GeometriesController@destroy'
    ]);

    Route::POST('geometries/deletebatch', [
        'as' => 'geometries.deletebatch',
        'uses' => 'API\GeometriesController@destroyBatch'
    ]);

    #endregion geometries

});
