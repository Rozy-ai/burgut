Yii::setAlias('@common', dirname(__DIR__)); Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend'); Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend'); Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console'); //Yii::setAlias('@uploads', dirname(dirname(__DIR__)) . '/backend/web/uploads'); Yii::setAlias('@uploads', dirname(dirname(__DIR__)) . '/uploads'); Yii::setAlias('@uploadsUrl', 'http://mintrans.hasaphesip.com/uploads/'); //Yii::setAlias('@formaticons', dirname(dirname(__DIR__)) . '/backend/web/formaticons'); Yii::setAlias('@formaticons', dirname(dirname(__DIR__)) . '/uploads/formaticons'); Yii::setAlias('@mysite', 'http://mintrans.hasaphesip.com');
Array
(
[vendorPath] => /home2/hasaphes/public_html/mintrans/vendor
[language] => tk
[modules] => Array
(
[user] => Array
(
[class] => dektrium\user\Module
[modelMap] => Array
(
[Profile] => common\models\Profile
)

[adminPermission] => admin
[as frontend] => dektrium\user\filters\FrontendFilter
[controllerMap] => Array
(
[security] => frontend\controllers\user\SecurityController
[registration] => frontend\controllers\user\RegistrationController
[recovery] => frontend\controllers\user\RecoveryController
)

[enablePasswordRecovery] => 1
)

[rbac] => Array
(
[class] => dektrium\rbac\RbacWebModule
)

[main] => Array
(
[class] => app\modules\main\Module
)

[seller] => Array
(
[class] => app\modules\seller\Module
)

[indexchecker] => Array
(
[class] => frontend\modules\indexchecker\Module
)

[productmatcher] => Array
(
[class] => frontend\modules\productmatcher\Module
)

[debug] => Array
(
[class] => yii\debug\Module
)

[gii] => Array
(
[class] => yii\gii\Module
)

)

[components] => Array
(
[i18n] => Array
(
[translations] => Array
(
[app*] => Array
(
[class] => yii\i18n\PhpMessageSource
[basePath] => @common/messages
[fileMap] => Array
(
[app] => app.php
[app/error] => error.php
)

)

[backend*] => Array
(
[class] => yii\i18n\PhpMessageSource
[basePath] => @common/messages
[fileMap] => Array
(
[app] => backend.php
[app/error] => error.php
)

)

)

)

[cache] => Array
(
[class] => yii\caching\FileCache
)

[image] => Array
(
[class] => yii\image\ImageDriver
[driver] => GD
)

[common] => Array
(
[class] => common\components\Common
)

[mailer] => Array
(
[class] => yii\swiftmailer\Mailer
[viewPath] => @common/mail
[useFileTransport] =>
[transport] => Array
(
[class] => Swift_SmtpTransport
[host] => smtp.gmail.com
[username] => hasaphesip@gmail.com
[password] => mldqstptyfjguhan
[port] => 587
[encryption] => ssl
)

)

[urlManager] => Array
(
[class] => yii\web\UrlManager
[languages] => Array
(
[0] => en
[1] => ru
[2] => tk
)

[showScriptName] =>
[enablePrettyUrl] => 1
[rules] => Array
(
[/] => /view
[//] => /
[/] => /
)

)

[db] => Array
(
[class] => yii\db\Connection
[dsn] => mysql:host=localhost;dbname=websayt_mintrans
[username] => root
[password] =>
[charset] => utf8
)

[assetManager] => Array
(
)

[view] => Array
(
[theme] => Array
(
[pathMap] => Array
(
[@dektrium/user/views/settings] => @frontend/views/settings
[@dektrium/user/views/security] => @frontend/views/security
[@dektrium/user/views/registration] => @frontend/views/registration
[@dektrium/user/views/recovery] => @frontend/views/recovery
[@dektrium/user/views/layouts] => @frontend/views/layouts
)

)

)

[request] => Array
(
[class] => common\components\Request
[web] => /frontend/web
[csrfParam] => _csrf-frontend
[cookieValidationKey] => gM70QP9jA1GinuMnEEMtBUooxPrDzipS
)

[session] => Array
(
[name] => advanced-frontend
)

[log] => Array
(
[traceLevel] => 0
[targets] => Array
(
[0] => Array
(
[class] => yii\log\FileTarget
[levels] => Array
(
[0] => error
[1] => warning
)

)

)

)

[errorHandler] => Array
(
[errorAction] => site/error
)

)

[id] => app-frontend
[name] => Maroell.com
[basePath] => /home2/hasaphes/public_html/mintrans/frontend
[bootstrap] => Array
(
[0] => log
[1] => debug
[2] => gii
)

[controllerNamespace] => frontend\controllers
[layout] => @app/views/layouts/bootstrap
[params] => Array
(
[adminEmail] => hasaphesip@gmail.com
[supportEmail] => hasaphesip@gmail.com
[user.passwordResetTokenExpire] => 3600
)

)