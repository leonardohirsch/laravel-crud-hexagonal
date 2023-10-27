<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
|
*/

Route::get('courses/{key}', '\Src\Course\Infrastructure\GetCourseByController');
Route::get('courses', '\Src\Course\Infrastructure\GetCourseAllController');
Route::post('courses', '\Src\Course\Infrastructure\CreateCourseController');
Route::put('courses/{key}', '\Src\Course\Infrastructure\UpdateCourseController');
Route::delete('courses/{key}', '\Src\Course\Infrastructure\DeleteCourseController');
Route::post('courses/{courseId}/students', '\Src\Course\Infrastructure\CourseStudentController@attach');
Route::put('courses/{courseId}/students', '\Src\Course\Infrastructure\CourseStudentController@detach');
Route::post('courses/{courseId}/categories', '\Src\Course\Infrastructure\CourseCategoryController@attach');
Route::put('courses/{courseId}/categories', '\Src\Course\Infrastructure\CourseCategoryController@detach');
Route::post('courses/{courseId}/documents', '\Src\Course\Infrastructure\CourseDocumentController@attach');
Route::put('courses/{courseId}/documents', '\Src\Course\Infrastructure\CourseDocumentController@detach');


Route::get('students/{key}', '\Src\Student\Infrastructure\GetStudentByController');
Route::get('students', '\Src\Student\Infrastructure\GetStudentAllController');
Route::post('students', '\Src\Student\Infrastructure\CreateStudentController');
Route::put('students/{key}', '\Src\Student\Infrastructure\UpdateStudentController');
Route::delete('students/{key}', '\Src\Student\Infrastructure\DeleteStudentController');

Route::get('documents/{key}', '\Src\Document\Infrastructure\GetDocumentByController');
Route::get('documents', '\Src\Document\Infrastructure\GetDocumentAllController');
Route::post('documents', '\Src\Document\Infrastructure\CreateDocumentController');
Route::put('documents/{key}', '\Src\Document\Infrastructure\UpdateDocumentController');
Route::delete('documents/{key}', '\Src\Document\Infrastructure\DeleteDocumentController');

Route::get('categories/{key}', '\Src\Category\Infrastructure\GetCategoryByController');
Route::get('categories', '\Src\Category\Infrastructure\GetCategoryAllController');
Route::post('categories', '\Src\Category\Infrastructure\CreateCategoryController');
Route::put('categories/{key}', '\Src\Category\Infrastructure\UpdateCategoryController');
Route::delete('categories/{key}', '\Src\Category\Infrastructure\DeleteCategoryController');
