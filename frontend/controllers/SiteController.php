<?php
namespace frontend\controllers;

use common\models\Item;
use yii\helpers\Html;
use common\models\ItemLang;
use common\models\search\ItemLangSearch;
use common\models\search\ItemSearch;
use common\models\wrappers\AlbumWrapper;
use common\models\wrappers\ContactWrapper;
use common\models\wrappers\ItemWrapper;
use common\models\wrappers\CategoryWrapper;
use common\models\wrappers\ImageWrapper;
use common\models\wrappers\OwnerContactWrapper;
use common\models\wrappers\SubscriberWrapper;
use common\rbac\UserProfileOwnerRule;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\components\CommonController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\components\Common;
use yii\web\ViewAction;
use yii\helpers\ArrayHelper;

ini_set('max_execution_time', 6000);

/**
 * Site controller
 */
class SiteController extends CommonController
{
    public $layout = 'bootstrap';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
//        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup', 'search'],
////                'rules' => [
////                    [
////                        'actions' => ['index','error','contact','about'],
////                        'allow' => true,
////                        'roles' => ['@'],
////                    ],
////                ],
//                'rules' => [
//                    [
//                        'actions' => ['search'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['index', 'error', 'contact', 'about'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ]
//        ]);

//
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'rules' => [
            //         [
            //             'actions' => ['login', 'error', 'upload', 'deleteupload'],
            //             'allow' => true,
            //         ],
            //         [
            //             'actions' => ['logout', 'index', 'about', 'contact', 'search', 'subscribe'],
            //             'allow' => true,
            //             'roles' => ['@'],
            //         ],
            //     ],
            // ],
                        'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'pages' => [
                'class' => 'yii\web\ViewAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
         $model = new SubscriberWrapper();
         //  if ($model->load(Yii::$app->request->post()) && $model->validate()){
         //    return $this->render('site/subscription', ['model' => $model]);
         //  } 
        // $this->layout = 'fullpage';
//        $aboutCategory = CategoryWrapper::find()->where(['code' => 'about'])->one();
//        $mainAboutItem = ItemWrapper::find()
//            >leftJoin('tbl_category cat', 'cat.id= tbl_item.category_id')
//            ->where(['tbl_item.is_main' => 1, 'cat.code' => 'about'])
//            ->orderBy('date_modified desc')->one();-
//
//
//        $itemCategory = CategoryWrapper::find()->where(['code' => 'item'])->one();
//        $customItems = ItemWrapper::find()
//            ->leftJoin('tbl_category cat', 'cat.id= tbl_item.category_id')
//            ->where(['cat.code' => 'item'])
//            ->orderBy('date_modified desc')
//            ->limit('3')
//            ->all();
//
//        $eventCategory = CategoryWrapper::find()->where(['code' => 'event'])->one();
//        $latestEventItem = ItemWrapper::find()
//            ->leftJoin('tbl_category cat', 'cat.id= tbl_item.category_id')
//            ->where(['cat.code' => 'event'])
//            ->orderBy('date_modified desc')
//            ->one();
//
//        $sliderImages = ImageWrapper::find()->where(['type' => ImageWrapper::IMAGE_SLIDER])->all();
    $sliders = ImageWrapper::find()->with(['translations','documents'])->where(['type' => ImageWrapper::IMAGE_SLIDER])->all();
    $category_advantages = CategoryWrapper::find()->where(['code' => 'advantage'])->one();
$catId = $category_advantages->id;
$advantages = ItemWrapper::find()->where(['category_id' => $catId, 'status' => '1'])->with(['documents','translations'])->orderBy('id')->all();
$category = CategoryWrapper::find()->where(['code' => 'magazin'])->one();
$catId = $category->id;
$new_products = ItemWrapper::find()->where(['parent_category_id' => $catId, 'status' => '1'])->with(['documents','translations'])->orderBy('id desc')->all();
// $hit_products = ItemWrapper::find()->where(['parent_category_id' => $catId, 'status' => '1'])->with(['documents','translations'])->orderBy('raiting desc')->all();
$ownInfo = \common\models\OwnerContact::find()->one();
$category_blog = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'blog'])->one();
$catId = $category_blog->id;
$blogs = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $catId, 'status' => '1'])->with(['documents','translations'])->orderBy('id desc')->all();
$category_partners = CategoryWrapper::find()->where(['code' => 'partners'])->one();
$catId = $category_partners->id;
$partners = ItemWrapper::find()->where(['category_id' => $catId, 'status' => '1'])->with(['documents','translations'])->orderBy('Rand()')->limit(8)->all();



        return $this->render('index', [
            'model' => $model,
            'sliders' => $sliders,
            'advantages' => $advantages,
            'new_products' => $new_products,
            'hit_products' => $hit_products,
            'ownInfo' => $ownInfo,
            'blogs' => $blogs,
            'category_blog' => $category_blog,
            'category' => $category,
//            'aboutCategory' => $aboutCategory,
//            'itemCategory' => $itemCategory,
//            'eventCategory' => $eventCategory,
//
//            'mainAboutItem' => $mainAboutItem,
//            'latestEventItem' => $latestEventItem,
//            'customItems' => $customItems,
//            'sliderImages' => $sliderImages,
        ]);
    }


//     public function actionSubscription(){
//         $model = Yii::$app->request->post();
//         var_dump($model);
//     if ($model->validate()){
//         $email = Html::encode($model->email);
//         $model->email = $email;
//         $model->addtime = (string) time();
//         if ($model->save()) {                
//             Yii::$app->response->refresh(); //очистка данных из формы
//             echo "<p style='color:green'>Подписка оформлена!</p>";
//             exit;
//         } 
//     } else {
//         echo "<p style='color:red'>Ошибка оформления подписки.</p>";
//         //Проверяем наличие фразы в массиве ошибки
//         if(strpos($model->errors['email'][0], 'уже занято') !== false) {
//             echo "<p style='color:red'>Вы уже подписаны!</p>";
//         }          
//     }        
//     exit;
// }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
//    public function actionLogin()
//    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            return $this->render('login', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
//    public function actionLogout()
//    {
//        Yii::$app->user->logout();
//
//        return $this->goHome();
//    }


    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        // $this->layout = 'bootstrap';
        $model = new ContactWrapper();
        $ownInfo = OwnerContactWrapper::find()->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            \Yii::$app->common->sendMail('testSubject','test text body','batya224@mail.ru');
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
                'ownInfo' => $ownInfo,
            ]);
        }
    }

    public function actionSubscribe()
    {
        $post = Yii::$app->request->post();
        $model = new SubscriberWrapper();
        $model->addtime = \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss');
         $email = Html::encode($post['SubscriberWrapper']['email']);
        $model->email = $email;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', yii::t('app', 'You have successfully subscribed'));
            }
        } else {
            Yii::$app->session->setFlash('error',  yii::t('app','There was an error sending email'));
        }

        return $this->redirect(Yii::$app->homeUrl);
    }

     public function actionLike()
    {
         // $model = new SubscriberWrapper();

      $id = Yii::$app->request->get('id');
      $product = \common\models\wrappers\ItemWrapper::findOne($id);
      if(empty($product)) return false;
      $product->liked = $product->liked + 1;
       $product->raiting = $product->liked + $product->visited_count;
      if ($product->save()) {
      return json_encode(['status' => 200]);
            } 
      else {
        return json_encode(['Error']);
      }
    }


    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
//        $email='batya224@gmail.com';
//        $subject="Product with ASIN have new hijacker seller";
//        $body="test body";
//
//        if(\Yii::$app->common->sendMail($subject,$body,$email)) {
//            echo "</br>Email  should be sent to: ".$email;
//        }
        return $this->render('about');
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

    public function actionSearch()
    {
        if (isset($_GET['query']) && isset($_GET['category'])) {
            $searchModel = new ItemLangSearch();
            $searchModel->status = 1;
            $searchModel->query = $_GET['query'];
            $searchModel->category = $_GET['category'];

            return $this->render('search_by_blog', ['items' => $searchModel->searchByCategory([]), 'pages' => $searchModel->pages, 'query' => $_GET['query']]);
        }
        if (isset($_GET['query'])) {
            $searchModel = new ItemLangSearch();
            $searchModel->status = 1;
            $searchModel->query = $_GET['query'];
            return $this->render('search', ['searchModel' => $searchModel->search([]), 'query' => $_GET['query']]);
        }

    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
//    public function actionSignup()
//    {
//        $model = new SignupForm();
//        if ($model->load(Yii::$app->request->post())) {
//            if ($user = $model->signup()) {
//                if (Yii::$app->getUser()->login($user)) {
//                    return $this->goHome();
//                }
//            }
//        }
//
//        return $this->render('signup', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
//    public function actionRequestPasswordReset()
//    {
//        $model = new PasswordResetRequestForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
//
//                return $this->goHome();
//            } else {
//                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
//            }
//        }
//
//        return $this->render('requestPasswordResetToken', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
//    public function actionResetPassword($token)
//    {
//        try {
//            $model = new ResetPasswordForm($token);
//        } catch (InvalidParamException $e) {
//            throw new BadRequestHttpException($e->getMessage());
//        }
//
//        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
//            Yii::$app->session->setFlash('success', 'New password was saved.');
//
//            return $this->goHome();
//        }
//
//        return $this->render('resetPassword', [
//            'model' => $model,
//        ]);
//    }


}
