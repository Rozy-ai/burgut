<?php
namespace common\widgets\language;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class LanguageSwitcherWidget extends \yii\base\Widget
{
    private static $_labels;

    private $_isError;
    public $items = [];
    public $showFlags;

    public function init()
    {
        if (!isset($this->showFlags)) {
            $this->showFlags = true;
        }

        $route = Yii::$app->controller->route;
        $appLanguage = Yii::$app->language;
        $params = $_GET;
        $this->_isError = $route === Yii::$app->errorHandler->errorAction;

        array_unshift($params, '/' . $route);

        foreach (Yii::$app->urlManager->languages as $language) {
            $active = false;
            $isWildcard = substr($language, -2) === '-*';
            if (
                $language === $appLanguage ||
                // Also check for wildcard language
                $isWildcard && substr($appLanguage, 0, 2) === substr($language, 0, 2)
            ) {
                $active = true;   // Exclude the current language
            }
            if ($isWildcard) {
                $language = substr($language, 0, 2);
            }

            $params['language'] = $language;
            $this->items[] = [
                'label' => self::label($language),
                'active' => $active,
                'code' => $language,
                'url' => $params,
            ];
        }
        parent::init();


    }


    public function run()
    {
        // Only show this widget if we're not on the error page
        if ($this->_isError) {
            return '';
        } else {
            $links = array();
            foreach ($this->items as $item) {
                $code = $item['code'];
                $image_path = Url::to('@web/source/img/flags/' . trim($code) . ".png");
                $image = Html::img($image_path, ['alt' => $code, 'class' => 'flag']);

//                if (isset($item['active']) && $item['active'] == true) {
//                    if ($this->showFlags)
//                        $links[] = $image;
//                    else {
//                        $links[] = Html::tag('li', $item['code']);
//                    }
//                    continue;
//                }

                if ($this->showFlags) {
                    $links[] = Html::a($image, $item['url']);
                } else {
                    $links[] = Html::a($image, $item['url']);
                }
            }

//            echo Html::tag('span', implode("\n", $links));
            echo implode("\n", $links);
        }
    }


    public static function label($code)
    {
        if (self::$_labels === null) {
            self::$_labels = [
                'ru' => Yii::t('app', 'Russian'),
                'tk' => Yii::t('app', 'Turkmen'),
                'en' => Yii::t('app', 'English'),
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }

}

?>