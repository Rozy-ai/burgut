<?php
namespace common\widgets\language;

use \Yii;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\helpers\Url;

class LanguageSwitcherDropdownWidget extends \yii\base\Widget {
    private static $_labels;

    private $_isError;
    public $items = [];

    public function init() {
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


    public function run() {
        // Only show this widget if we're not on the error page
        if ($this->_isError) {
            return '';
        } else {
            $links = array ();
            $selected_link = null;

            foreach ($this->items as $item) {
                $code = $item['code'];
                $image_path = Url::to('@web/source/img/flags/' . trim($code) . ".png");
                $image = Html::img($image_path, ['alt' => $code, 'class' => 'flag']);

                // if (isset($item['active']) && $item['active'] == true) {
                //     $selected_link = Html::a($image , $item['url'], ['id' => 'navbarDropdown', 'data-bs-toggle' => 'dropdown', 'class' => 'nav-link dropdown-toggle', 'style' => 'color: #fff; margin-top: 16%;']);
                //     continue;
                // }
                $links[] = Html::tag('li', Html::a($image , $item['url']));
            }

            $final_links = array ($selected_link, Html::tag('ul', implode($links), ['class' => 'lang_ul']));
//            $final_links = array_merge($final_links, $links);
            echo Html::tag('li', implode($final_links), ['class' => 'nav-item dropdown language-switcher']);
        }
    }


    public static function label($code) {
        if (self::$_labels === null) {
            self::$_labels = [
                'ru' => Yii::t('app', 'In Russian'),
                'tk' => Yii::t('app', 'In Turkmen'),
                'en' => Yii::t('app', 'In English'),
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }

}

?>