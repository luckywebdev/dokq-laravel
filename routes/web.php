<?php
include_once 'web_builder.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::pattern('slug', '[a-z0-9- _]+');
/* when logout, visible 16~135 rows*/
Route::get('/', 'HomeController@index')->name('home');
Route::get('/get_notice', 'HomeController@get_notice');
Route::post('/alerttomember', 'HomeController@alerttomember');

Route::get('/csrftoken','Auth\UserController@csrftokenAPI');

//Login
Route::get('/auth/login', 'Auth\LoginController@index')->name('auth/login');
Route::post('/auth/dologin', 'Auth\LoginController@login')->name('auth/dologin');
Route::get('/login', 'Auth\UserController@loginAPI');

//Forgot Password
Route::get('/auth/forgot_pwd', 'Auth\ForgotPasswordController@index');
Route::get('/auth/forgot_email_pwd', 'Auth\ForgotPasswordController@emailview');
Route::post('/auth/doforgot_email', 'Auth\ForgotPasswordController@doforgotemail');

// face recog
Route::post('/auth/faceSuccessAjax', 'Auth\UserController@faceSuccessAjax');
Route::get('/auth/register_face/{type}', 'Auth\UserController@viewFaceRegister');
Route::post('/auth/signin', 'Auth\UserController@signin');
Route::get('/auth/signin', 'Auth\UserController@signin');
Route::post('/auth/register_face', 'Auth\UserController@faceRegister');
Route::get('/auth/forgot_verify_face', 'Auth\ForgotPasswordController@faceVerify');
Route::post('/auth/forgot_pre_face_verify', 'Auth\ForgotPasswordController@preFaceVerify');
//Route::post('/auth/face_verify', 'Auth\UserController@faceVerify');
Route::post('/auth/face_verify_result', 'Auth\UserController@faceVerifyResult');
Route::post('/auth/overseerface_verify_result', 'Auth\UserController@overseerfaceVerifyResult');
Route::post('/auth/face_verify_email', 'Auth\UserController@faceVerifyEmail');
Route::post('/auth/signin_teacher', 'Auth\ForgotPasswordController@signinTeacher');
Route::get('/auth/signin_teacher', 'Auth\ForgotPasswordController@signinTeacher');
Route::post('/auth/password_teacher_verify', 'Auth\ForgotPasswordController@passwordTeacherVerify');


//Reset Password
Route::get('/auth/reset_pwd','Auth\ResetPasswordController@index');
Route::post('/auth/doresetpwd', 'Auth\ResetPasswordController@doreset');
Route::get('/auth/reset_pwd_success', 'Auth\ResetPasswordController@success');

//Register

Route::get('/auth/register', 'Auth\RegisterController@index')->name('auth/register');
Route::get('/choose_payment', 'Auth\RegisterController@payment');
Route::post('/auth/doregister', 'Auth\RegisterController@register')->name('auth/doregister');
Route::get('/register/{type}/{step}', 'Auth\RegisterController@viewregisterAPI');       ////////////////////

Route::get('/auth/register/{type}/{step}', 'Auth\RegisterController@viewregister')->name('auth/register/view');
Route::post('/auth/register/prepay', 'Auth\RegisterController@prepay');
Route::get('/auth/register/getPayment_result', 'Auth\RegisterController@getPayment_result');
Route::get('/auth/register/getPayment_result_cancel', 'Auth\RegisterController@getPayment_result_cancel');
Route::post('/auth/register/getPayment_result', 'Auth\RegisterController@getPayment_result');
Route::post('/auth/register/getPayment_result_cancel', 'Auth\RegisterController@getPayment_result_cancel');
Route::get('/auth/register/filesizecheck', 'Auth\RegisterController@filesizecheck');
Route::get('/auth/user_escape','Auth\UserController@userEscape');
Route::post('/auth/escape_group','Auth\UserController@escape_group');
Route::post('/auth/escape_mail','Auth\UserController@escape_mail');
Route::post('/auth/register/checktempauth','Auth\RegisterController@checktempauth');
Route::post('/auth/register/enterdetaildata', 'Auth\RegisterController@enterdetaildata');
Route::get('/user/dupdoqusercheck','Auth\UserController@dupDoqUserCheck');
Route::get('/user/duppasswordcheck','Auth\UserController@duppasswordcheck');
Route::get('/auth/download/{username}', 'Auth\RegisterController@downloadAuthFile')->name('auth/download');
Route::get('/auth/reg_step1/{role}/suc', 'Auth\RegisterController@step1_suc');
Route::get('/auth/reg_step2/{role}/suc', 'Auth\RegisterController@step2_suc');
Route::get('/auth/reg_step3/{role}/suc','Auth\RegisterController@step3_suc');
Route::get('/auth/reg_step4/{role}/suc','Auth\RegisterController@step4_suc');
Route::post('/auth/viewpdf', 'HelpController@viewpdf');
Route::get('/auth/viewpdf', 'HelpController@viewpdf');
Route::post('/auth/changepassword', 'Auth\UserController@changepassword');

//Class CRUD: AJAX API
Route::get('/classes/add','ClassController@addclass');
Route::get('/classes/del', 'ClassController@delclass');
Route::get('/classes/get', 'ClassController@getclass');
Route::get('/classes/update', 'ClassController@updateclass');
Route::get('/classes/check', 'ClassController@check');

//class CR: message
Route::post('/message/create', 'MessageController@create');
Route::post('/message/update', 'MessageController@update');
Route::post('/message/delete', 'MessageController@delete');

Route::get('/about_site', 'HelpController@aboutSite');
Route::get('/about_score', 'HelpController@aboutScore');
Route::get('/about_target', 'HelpController@aboutTarget');
Route::get('/about_overseer', 'HelpController@aboutoverseer');
Route::get('/about_test', 'HelpController@aboutTest');
Route::get('/about_recog', 'HelpController@aboutRecog');
Route::get('/about_sitemap', 'HelpController@aboutSiteMap');
Route::get('/outline', 'HelpController@viewOutline');
Route::get('/agreement', 'HelpController@viewAgreement');
Route::get('/about_pay', 'HelpController@aboutPay');
Route::get('/security', 'HelpController@aboutSecurity');
Route::get('/ask', 'HelpController@viewAsk');  
Route::get('/auth/viewpdf/{book_index}', 'HelpController@viewpdf');

Route::post('/ask/sendMessage', 'HelpController@sendMessage');
Route::get('/faq', 'HelpController@viewFaq');
Route::post('/help/storepdfheight', 'HelpController@storepdfheight');

Route::get('/book/search', 'BookController@index');//` index page
Route::get('/book/search_one/{id}', 'BookController@searchById');//` index page
Route::get('/book/search_result', 'BookController@search');//search engine and result page
Route::get('/book/search_books_byauthor', 'BookController@searchbooksbyauthor');//search books by author
Route::get('/book/search/sort', 'BookController@searchBySort');//良さそうな本を選ぶ場合
Route::get('/book/search/gene', 'BookController@searchByGene');//search by recommend generation
Route::get('/book/search/category', 'BookController@searchByCategory');
Route::get('/book/search/latest', 'BookController@searchLatest');
Route::get('/book/search/latest1', 'BookController@searchLatest1');
Route::post('/book/search/ranking', 'BookController@searchByRanking');
Route::get('/book/quizbook', 'BookController@quizbook');
Route::get('/book/search/help', 'BookController@searchHelp');
Route::get('/book/result/help', 'BookController@resultHelp');
Route::get('/book/{id}/detail', 'BookController@showDetail');
Route::post('/book/detail', 'BookController@showDetail');
Route::post('/book/accept', 'BookController@accept_book');
Route::post('/book/quizfinish', 'BookController@quizfinish');
Route::post('/book/bookregisterAjax', 'BookController@bookregisterAjax');
Route::get('/quiz/make/caution', 'BookController@index');
Route::get('/quiz/make/caution1', 'QuizController@caution');
Route::post('/quiz/make/caution1', 'QuizController@caution');
Route::get('/quiz/answer', 'QuizController@answer');
Route::get('/quiz/rank_by_quiz', 'QuizController@rank_by_quiz');
Route::get('/quiz/remove/{id}', 'QuizController@remove_quiz');
Route::get('/mypage/book_ranking', 'MypageController@book_ranking');
Route::post('/mypage/certi_print', 'MypageController@certi_print');
Route::get('/mypage/passcode','MypageController@passcode');
Route::get('/mypage/passcode/{index}','MypageController@passcode');
Route::get('/mypage/settlement_certi_view/{userid}/{index}', 'MypageController@settlement_certi_view');

/* when login, visible after this rows*/
Route::group(['middleware' => 'auth'], function(){
    Route::get('/top', 'HomeController@top')->name('top');

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

//    Route::get('/auth/reg/step2', 'Auth\UserController@getStep2');  
//    Route::post('/auth/reg/step2', 'Auth\UserController@postStep2');  
//    Route::get('/auth/reg/step3', 'Auth\UserController@getStep3');  
    // Route::get('/ask', 'HelpController@viwAsk');  

    Route::post('/class/register', 'Auth\UserController@regClass');
    Route::get('/group/reg/step2', 'Auth\UserController@step2_confirm');
    Route::get('/group/reg/step3', 'Auth\UserController@groupStep3');
    Route::get('/group/reg/step3_suc', 'Auth\UserController@getStep3_suc'); 
    Route::get('/group/reg/step4', 'Auth\UserController@getStep4'); 

///////////////////group account////////////
    Route::post('/class_top','ClassController@index' );
    Route::get('/class/{id}/top','ClassController@toppage' );
    Route::get('/group/basic_info', 'GroupController@editGroup');
    Route::get('/group/basic_info/{id}', 'GroupController@editGroup1');
    Route::get('/group/search_teacher', 'GroupController@searchTeacher');
    Route::post('/group/teacher/register', 'GroupController@registerTeacher');//register teachers to school
    Route::get('/group/teacher/reg_class', 'GroupController@reg_class');//2.2e役割 : 担任登録
    Route::get('/group/teacher/edit_class', 'GroupController@edit_class'); //2.2f役割 : 担任編集
    Route::post('/group/teacher/doedit_class', 'GroupController@doedit_class');
    Route::post('/group/teacher/edit_class/search', 'GroupController@edit_class_search');
    Route::post('/group/teacher/selteachername', 'GroupController@selTeacherName');
    Route::get('/group/manual', 'GroupController@manual');
    Route::get('/group/edit_teacher_top', 'GroupController@edit_teacher_top');
    Route::post('/group/teacher/doreg_class','GroupController@doreg_class');
    Route::get('/group/teacher/list', 'GroupController@teacher_list');
    Route::post('/group/teacher/dosearchteacher', 'GroupController@dosearchteacher');
    Route::get('/group/teacher/{action}/card', 'GroupController@TeacherCard');
    Route::post('/group/teacher/update', 'GroupController@updateTeacher');
    Route::post('/group/teacher/delete', 'GroupController@deleteTeacher');
    Route::get('/group/rank/{type}', 'GroupController@ViewGroupRank');
    Route::post('/group/selClassAjax', 'GroupController@selClassAjax');
///////////////////teacher account////////////////////////////
    Route::get('/class/rank/{type}','ClassController@viewClassRank' );
    Route::get('/class/search_pupil','ClassController@search_pupil');
    Route::post('/class/search_pupil/check','ClassController@searchPupilCheck');
    Route::get('/class/pupil/unlock', 'ClassController@pupil_unlock');
//////////////////////role of teacher/////////////////////////
    Route::get('/teacher/reg_pupil', 'TeacherController@reg_pupil');
    Route::get('/teacher/edit_pupil','TeacherController@edit_pupil');
    
    Route::post('/teacher/pupil/{mode}/reg', 'TeacherController@RegisterPupil');
    Route::post('/teacher/pupil/action','TeacherController@action_pupil');    
    Route::get('/teacher/pupil/delete','TeacherController@delete_pupil');
    Route::get('/teacher/pupil/remove','TeacherController@remove_pupil');
    Route::get('/teacher/pupil/move','TeacherController@move_pupil');
    Route::get('/teacher/pupil/graduate','TeacherController@graduate_pupil');
    
    Route::get('/teacher/class_list', 'TeacherController@viewClassList');
    Route::get('/teacher/pwd_history', 'TeacherController@viewPwdHistory');
    Route::any('/teacher/send_notify', 'TeacherController@sendNotify');
    Route::get('/teacher/del_notify','TeacherController@delNotify');
    Route::post('/teacher/post_notify','TeacherController@post_notify');
    Route::get('/teacher/cancel_pass', 'TeacherController@cancelPass');
    Route::post('/teacher/checkPupilExists', 'TeacherController@checkPupilExists');
    Route::post('/teacher/movewtoUsername', 'TeacherController@movewtoUsername');
    Route::post('/teacher/checkSamePupil', 'TeacherController@checkSameUser');
    Route::post('/teacher/record/delete', 'TeacherController@deleteRecord');

//////////////////////common////////////////////////////
    Route::get('/mypage/top', 'MypageController@index');//render mypage
    Route::get('/mypage/top/setpublic', 'MypageController@setPublic');
    Route::post('/mypage/top/setpublic/{type}', 'MypageController@setPublic');
    Route::get('/mypage/bottom', 'MypageController@bottom');
    Route::get('/mypage/other_view', 'MypageController@other_view');
    Route::get('/mypage/other_view/{id}', 'MypageController@other_view');
    Route::get('/mypage/pupil_view', 'MypageController@pupil_view');
    Route::get('/mypage/pupil_view/{id}', 'MypageController@pupil_view');
    Route::get('/mypage/face_verify', 'MypageController@viewFaceVerify');
    Route::get('/mypage/face_verify/{index}', 'MypageController@viewFaceVerify');
  //  Route::get('/mypage/signin', 'MypageController@signin');
    Route::post('/mypage/signin', 'MypageController@signin');
    Route::post('/mypage/signin_teacher', 'MypageController@signinTeacher');
    Route::get('/mypage/signin_teacher', 'MypageController@signinTeacher');
    Route::post('/mypage/password_teacher_verify', 'MypageController@passwordTeacherVerify');
    Route::post('/mypage/register_face', 'MypageController@faceRegister');
    Route::get('/mypage/site_notify', 'MypageController@site_notify');
    Route::get('/mypage/site_notify/{id}', 'MypageController@site_notify');
    Route::get('/mypage/category', 'MypageController@category');
    Route::get('/mypage/category/{id}', 'MypageController@category');
    Route::get('/mypage/wish_list', 'MypageController@wish_list');
    Route::get('/mypage/wish_list/{id}', 'MypageController@wish_list');
    Route::post('/mypage/wish_list/setpublic/{type}/{id}', 'MypageController@SetWishlistPublic');
    Route::get('/mypage/rank_child', 'MypageController@rank_child');
    Route::get('/mypage/rank_child/{id}', 'MypageController@rank_child');
    Route::get('/mypage/rank_child_pupil', 'MypageController@rank_child_pupil');
    Route::get('/mypage/rank_child_pupil/{id}', 'MypageController@rank_child_pupil');
    Route::get('/mypage/rank_by_age', 'MypageController@rank_by_age');
    Route::get('/mypage/rank_by_age/{id}', 'MypageController@rank_by_age');
    Route::get('/mypage/rank_graph', 'MypageController@rank_graph');
    Route::get('/mypage/rank_graph/{id}', 'MypageController@rank_graph');
    Route::get('/mypage/rank_bq', 'MypageController@rank_bq');
    Route::get('/mypage/rank_bq/{id}', 'MypageController@rank_bq');
    Route::get('/mypage/rank_bq_child', 'MypageController@rank_bq_child');
    Route::get('/mypage/rank_bq_child/{id}', 'MypageController@rank_bq_child');
    Route::get('/mypage/history_all', 'MypageController@history_all');
    Route::get('/mypage/history_all/{id}', 'MypageController@history_all');
    Route::get('/mypage/pass_history', 'MypageController@pass_history');
    Route::get('/mypage/pass_history/{id}', 'MypageController@pass_history');
    Route::post('/mypage/pass_history/setpublic/{type}/{id}', 'MypageController@SetQuizPublic');
    Route::get('/mypage/quiz_history', 'MypageController@quiz_history');
    Route::get('/mypage/quiz_history/{id}', 'MypageController@quiz_history');
    Route::get('/mypage/book_reg_history', 'MypageController@book_reg_history');
    Route::get('/mypage/book_reg_history/{id}', 'MypageController@book_reg_history');
    Route::get('/mypage/recent_report', 'MypageController@recent_report');
    Route::post('/mypage/recent_print', 'MypageController@recent_print');
    Route::get('/mypage/last_report', 'MypageController@last_report');
    Route::get('/mypage/last_report/{mode}', 'MypageController@last_report');
    Route::get('/mypage/last_report/{mode}/{id}', 'MypageController@last_report');
    Route::post('/mypage/last_print', 'MypageController@last_print');
    Route::get('/mypage/article_history', 'MypageController@article_history');
    Route::get('/mypage/article_history/{id}', 'MypageController@article_history');
    Route::post('/mypage/article_history_ajax/{mode}', 'MypageController@article_history_ajax');
    Route::get('/mypage/main_info', 'MypageController@main_info');
    Route::get('/mypage/recognize', 'MypageController@recognize');
    Route::post('/mypage/edit_info', 'MypageController@edit_info');
    Route::get('/mypage/edit_info', 'MypageController@edit_info');
    Route::post('/mypage/edit_info/update', 'MypageController@update_info');
    Route::get('/mypage/other_view_info', 'MypageController@other_view_info');
    Route::get('/mypage/other_view_info/{id}', 'MypageController@other_view_info');
    Route::get('/mypage/become_overseer', 'MypageController@become_overseer');
    Route::post('/mypage/update_userinfo', 'MypageController@update_userinfo');
    Route::get('/mypage/escape_group', 'MypageController@escape_group');
    Route::post('/mypage/payment', 'MypageController@payment');
    Route::get('/mypage/payment', 'MypageController@payment');
    Route::post('/mypage/getPayment_result', 'MypageController@getPayment_result');
    Route::get('/mypage/getPayment_result', 'MypageController@getPayment_result');
    Route::post('/mypage/getPayment_result/{index}', 'MypageController@getPayment_result');
    Route::get('/mypage/getPayment_result/{index}', 'MypageController@getPayment_result');
    Route::post('/mypage/periodPayment', 'MypageController@periodPayment');
    Route::get('/mypage/periodPayment', 'MypageController@periodPayment');
    Route::get('/mypage/create_certi', 'MypageController@create_certi');
    Route::get('/mypage/certi_check/{index}', 'MypageController@certi_check');
    Route::get('/mypage/sample_certi', 'MypageController@sample_certi');
    Route::get('/mypage/preview_certi/{index}', 'MypageController@preview_certi');
    Route::post('/mypage/preview_certi/{index}', 'MypageController@preview_certi');
    Route::get('/mypage/search_certi/{index}', 'MypageController@search_certi');
    Route::get('/mypage/settlement_certi/{index}/{items}', 'MypageController@settlement_certi');
    Route::get('/mypage/certi_pay/{index}', 'MypageController@certi_pay');
    Route::get('/mypage/settlement_user/{index}', 'MypageController@settlement_user');
    Route::get('/mypage/search_list', 'MypageController@search_list');
    Route::get('/mypage/oversee_test', 'MypageController@oversee_test');
    Route::post('/mypage/overseer_test_start', 'MypageController@overseerTestStart');
    Route::get('/mypage/test_overseer', 'MypageController@test_overseer');
    Route::get('/mypage/history_oversee', 'MypageController@history_oversee');
    Route::get('/mypage/history_oversee/{id}', 'MypageController@history_oversee');
    Route::get('/mypage/acceptable_quiz_list/{id}','MypageController@acceptable_quiz_list');
    Route::get('/mypage/schoolrank/{id}','MypageController@ViewGroupRank');
	Route::get('/mypage/accept_quiz_list/{id}', 'MypageController@accept_quiz_list');
    Route::post('/mypage/accept_quiz_list', 'MypageController@accept_quiz_list');
    Route::get('/mypage/quiz_store/{type}/{id}', 'MypageController@quiz_store');
    Route::get('/mypage/mybooklist', 'MypageController@mybooklist');
    Route::get('/mypage/mybooklist/{id}', 'MypageController@mybooklist');
    Route::post('/mypage/demand_list', 'MypageController@demandList');
    Route::get('/mypage/demand_list', 'MypageController@demandList');
    Route::get('/mypage/demand_list/{id}', 'MypageController@demandList');
    //Route::get('/mypage/demand/{id}', 'MypageController@demand');
    Route::post('/mypage/demand', 'MypageController@demand');
    Route::post('/mypage/select_demand', 'MypageController@select_demand');
    Route::get('/mypage/ok_certi', 'MypageController@ok_certi');
    Route::get('/mypage/bid_history', 'MypageController@bid_history');
    Route::get('/mypage/bid_history/{id}', 'MypageController@bid_history');
    Route::get('/mypage/overseer_books', 'MypageController@overseerBooks');
    Route::get('/mypage/overseer_books/{id}', 'MypageController@overseerBooks');
    Route::get('/mypage/my_profile', 'MypageController@my_profile');
    Route::post('/mypage/my_profile/update','MypageController@update_my_profile');
    Route::get('/mypage/pupil_history','MypageController@pupil_history');
    
////book indexing.//////////////
    Route::get('/book/register', 'BookController@register');
    Route::get('/book/register/caution', 'BookController@caution');
    Route::post('/book/create_update', 'BookController@create_update');
    Route::post('/book/subsave', 'BookController@subsave');
    Route::get('/book/{id}/edit/{msgId}', 'BookController@edit');
    Route::get('/book/register/{id}/confirm', 'BookController@confirm');
    Route::get('/book/book_edit_confirm', 'BookController@bookEditConfirm');
    Route::post('/book/delete_book/{id}', 'BookController@delete_book');
	Route::post('/book/search/isbn', 'BookController@searchByIsbn');
    Route::post('/book/search/bookoutAjax', 'BookController@bookoutAjax');

    //Route::get('/quiz/index', 'QuizController@index');
    Route::get('/quiz/index', 'QuizController@caution');
    Route::get('/quiz/create', 'QuizController@create');
    Route::get('/quiz/remove', 'QuizController@remove');
    Route::post('/quiz/store', 'QuizController@store');
    Route::get('/quiz/store/confirm', 'QuizController@confirmStore');
    Route::post('/quiz/update', 'QuizController@update');
    Route::get('/quiz/store/completed', 'QuizController@completed');
    Route::post('/quiz/isOverseerQuizAjax', 'QuizController@isOverseerQuizAjax');
    Route::get('/quiz/accept', 'QuizController@accept_quiz');
    Route::get('/quiz/reject/{id}', 'QuizController@reject_quiz');

    Route::get('/book/{book_id}/article/create', 'BookController@createArticle');
    Route::get('/book/{book_id}/article/manage', 'BookController@manageArticle');
    Route::post('/book/{book_id}/article/delete', 'BookController@deleteArticle');
    Route::get('/book/{article_id}/update_article_vote', 'BookController@UpdateArticleVote');
    Route::post('/book/{book_id}/add_article', 'BookController@AddArticle');
    //Route::get('/book/{book_id}/test', 'BookController@openTest');
    Route::post('/book/test', 'BookController@openTest');
    Route::get('/book/{book_id}/delete', 'BookController@deleteWishBook');
    Route::get('/book/test/caution', 'BookController@viewTestCaution');
    Route::post('/book/test/caution', 'BookController@viewTestCaution');
    Route::post('/book/test/agree', 'BookController@agreeCaution');
    Route::get('/book/test/faceverify_error_delete', 'BookController@deletefaceverify');
    Route::post('/book/test/signin', 'BookController@testSignin');
    Route::get('/book/test/signin', 'BookController@testSignin');
    Route::post('/book/test/success_signin', 'BookController@successSignin');
    Route::post('/book/test/signin_overseer', 'BookController@signinOverseer');
    Route::get('/book/test/signin_overseer', 'BookController@signinOverseer'); 
    Route::post('/book/test/signin_teacher', 'BookController@signinTeacher');
    Route::get('/book/test/signin_teacher', 'BookController@signinTeacher');
    Route::post('/book/test/password_teacher_verify', 'BookController@passwordTeacherVerify');
    Route::get('/book/test/forget_pwd', 'BookController@viewForgetPwd');
    Route::post('/book/test/forget_pwd/mail','BookController@sendMail');
    Route::get('/book/test/mode_recog', 'BookController@viewRecogMode');
    Route::post('/book/test/start', 'BookController@startTest');
    //Route::get('/book/test/start', 'BookController@startTest');
    //Route::get('/book/test/quiz', 'BookController@viewTestQuiz');
    Route::post('/book/test/testquizajax', 'BookController@testQuizAjax');
    Route::post('/book/test/quiz', 'BookController@viewTestQuiz');
    Route::post('/book/test/success', 'BookController@viewTestSuccess');
    Route::get('/book/test/failed', 'BookController@viewTestFailed');
    Route::get('/book/test/stoped', 'BookController@viewTestStoped');
    Route::get('/book/test/post_success', 'BookController@postTestSuccess');
    Route::get('/book/{id}/search_passer', 'BookController@search_passer');
    Route::post('/book/{id}/res_passer', 'BookController@res_passer');
    Route::post('/book/regWishlist', 'BookController@regWishlist');
    Route::post('/book/regTestSuccess', 'BookController@regTestSuccess');
    Route::post('/book/sessionquiztime', 'BookController@sessionquiztime');
    
    Route::get('/admin/reg_group_list', 'AdminController@reg_group_list');
    Route::get('/admin/reg_person_list', 'AdminController@reg_person_list');
    Route::get('/admin/unsubscribe_list', 'AdminController@unsubscribe_list');
    Route::get('/admin/unsubscribe_email/{user_id}', 'AdminController@unsubscribe_email');
    Route::get('/admin/pay_list', 'AdminController@pay_list');
    Route::get('/admin/reg_overseer_list', 'AdminController@reg_overseer_list');
    Route::get('/admin/can_book_list', 'AdminController@can_book_list');
    Route::get('/admin/can_book_a/{id}', 'AdminController@can_book_a');
    Route::post('/admin/do_can_book_a', 'AdminController@do_can_book_a');
    Route::get('/admin/can_book_b', 'AdminController@can_book_b');
    Route::post('/admin/do_can_book_b', 'AdminController@do_can_book_b');
    Route::get('/admin/can_book_c', 'AdminController@can_book_c');
    Route::post('/admin/do_can_book_c', 'AdminController@do_can_book_c');
    Route::get('/admin/can_book_d', 'AdminController@can_book_d');
    Route::get('/admin/can_book_e/{id}', 'AdminController@can_book_e');
    Route::post('/admin/recommend_change', 'AdminController@recommend_change');
    Route::post('/admin/recommend_nochange', 'AdminController@recommend_nochange');
    Route::get('/admin/data_work_sel', 'AdminController@data_work_sel');
    Route::post('/admin/data_card_per', 'AdminController@data_card_per');
    Route::get('/admin/data_card_per', 'AdminController@data_card_per');
    Route::get('/admin/personaldata/{id}', 'AdminController@personalData');
    Route::get('/admin/data_card_org/{id}', 'AdminController@data_card_org');
    Route::post('/admin/data_card_org_view', 'AdminController@data_card_org_view');
    Route::post('/admin/save_org_data', 'AdminController@saveOrgData');
    Route::get('/admin/data_card_book', 'AdminController@data_card_book');
    Route::get('/admin/data_card_quiz', 'AdminController@data_card_quiz');
    Route::get('/admin/manual_quiz', 'AdminController@manual_quiz');
    Route::get('/admin/advertise', 'AdminController@advertise');
    Route::post('/admin/ad_save', 'AdminController@ad_save');
    Route::get('/admin/app_search_history', 'AdminController@app_search_history');
    Route::post('/admin/exportSearchbook', 'AdminController@exportSearchbook');
    Route::post('/admin/exportQuizemake', 'AdminController@exportQuizemake');
    Route::post('/admin/exportOverseer', 'AdminController@exportOverseer');
    Route::post('/admin/exportHelppage', 'AdminController@exportHelppage');
    Route::get('/admin/book_ranking', 'AdminController@book_ranking');
    Route::get('/admin/auto_mail_send', 'AdminController@auto_mail_send');
    Route::get('/admin/auto_mail_setting', 'AdminController@auto_mail_setting');
    Route::get('/admin/popup_text', 'AdminController@popup_text');
    Route::get('/admin/mail_soft', 'AdminController@mail_soft');
    Route::get('/admin/report_auto_send', 'AdminController@report_auto_send');
    Route::get('/admin/mem_search', 'AdminController@mem_search');
    Route::post('/admin/mem_search_result', 'AdminController@mem_search_result');
    Route::get('/admin/mem_search_result', 'AdminController@mem_search_result');
    Route::post('/admin/several_search_result', 'AdminController@several_search_result');
    Route::get('/admin/several_search_result', 'AdminController@several_search_result');
    Route::get('/admin/quiz_answer', 'AdminController@quiz_answer');
    Route::get('/admin/quiz_answer_card', 'AdminController@quiz_answer_card');
    Route::get('/admin/basic_list', 'AdminController@basic_list');
    Route::get('/admin/basic_info/{id}', 'AdminController@basic_info');
    Route::post('/admin/updatebasicinfo', 'AdminController@updatebasicinfo');
    Route::get('/admin/notice', 'AdminController@notice');
    Route::post('/admin/notice_add_edit', 'AdminController@notice_add_edit');
    Route::get('/admin/notice_update_edit', 'AdminController@notice_update_edit');
    Route::get('/admin/notice_delete_edit', 'AdminController@notice_delete_edit');
    Route::get('/admin/book_credit', 'AdminController@book_credit');
    Route::get('/admin/bookdata/{id}', 'AdminController@bookData');
    Route::post('/admin/bookdata_view', 'AdminController@bookdata_view');
    Route::get('/admin/bookdata_view', 'AdminController@bookdata_view');
    Route::post('/admin/save_book_data', 'AdminController@saveBookData');
    Route::get('/admin/export_book_data/{id}', 'AdminController@exportBookData');
    Route::get('/admin/export_book_data', 'AdminController@exportBookData');
    Route::post('/admin/export_book_data', 'AdminController@exportBookData');
    Route::get('/admin/export_personal_data/{id}', 'AdminController@exportPersonalData');
    //Route::get('/admin/export_personaluse_data/{id}', 'AdminController@exportPersonaluseData');
    Route::get('/admin/export_personal_list', 'AdminController@exportPersonalList');
    Route::post('/admin/export_personal_list', 'AdminController@exportPersonalList');
    Route::get('/admin/export_group_list', 'AdminController@exportGrouplList');
    Route::post('/admin/export_group_list', 'AdminController@exportGrouplList');
    Route::get('/admin/export_org_data', 'AdminController@exportOrgData');
    Route::post('/admin/export_org_data', 'AdminController@exportOrgData');
    Route::post('/admin/export_school_data', 'AdminController@exportSchoolData');
    Route::get('/admin/export_orguse_data/{id}', 'AdminController@exportOrguseData');
    Route::post('/admin/save_personal_data', 'AdminController@savePersonalData');
    Route::post('/admin/messagesend', 'AdminController@messagesend');
    Route::post('/admin/messagesend1', 'AdminController@messagesend1');
    Route::get('/admin/teachertop/{id}', 'AdminController@teachertop');
    Route::get('/admin/quizdata/{id}', 'AdminController@quizData');
    Route::post('/admin/quizdata_view', 'AdminController@quizdata_view');
    Route::get('/admin/export_quiz_data/{id}/{quizid}', 'AdminController@exportQuizData');
    Route::post('/admin/deletearticlebyadmin', 'AdminController@deleteArticleByAdmin');
    Route::post('/admin/exportPersonaluseData', 'AdminController@exportPersonaluseData');
    Route::get('/admin/messages1', 'AdminController@messages1');
    Route::get('/admin/messages2', 'AdminController@messages2');
    Route::post('/admin/success_cancel', 'AdminController@successCancel');
    Route::post('/admin/deletebookByAdmin', 'AdminController@deletebookByAdmin');
    Route::post('/admin/deleteperByAdmin', 'AdminController@deleteperByAdmin');
    Route::post('/admin/deleteorgByAdmin', 'AdminController@deleteorgByAdmin');

});