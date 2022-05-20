{% if ajax == true %}
{% else %}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/public/css/style.min.css">
    <title>{{meta.title}}</title>
</head>
<body>
<div class="wrap">
    <header class="header">
        <div class="header__body _container">
            <img class="header__logo" src="/public/img/logo.png" alt="">
            <div class="header__icons">
                <div class="header__icon">
                    <a href="permission.html" class="header__link">
                        <span class="icon-user"></span>
                        <span class="header__subtitle">
                        Разрешения
                    </span>
                    </a>
                </div>
                <div class="header__icon icon_reg_auth">
                    <span class="icon-user"></span>
                    <span class="header__subtitle">
                    Войти
                </span>
                </div>
                <form method="post" class="header__icon header__exit icon_reg_auth">
                    <span class="icon-exit"></span>
                    <span class="header__subtitle">
                    Выйти
                </span>
                    <input type="text" readonly value="Выйти" hidden name="exit">
                </form>
            </div>
        </div>
    </header>
    <main class="content">
        <div class="content__body _container">
<!--            <p><b>Start typing a name in the input field below:</b></p>-->
<!--            <form action="" method="post">-->
<!--                <label for="fname">First name:</label>-->
<!--                <input type="text" id="fname" name="fname" onkeyup="showHint(this.value)">-->
<!--            </form>-->
<!--            <p>Suggestions: <span id="txtHint"></span></p>-->
            <div class="navigation-chain">
                <div class="navigation-chain__item"><a href="http://trans/permission">Разрешения / </a></div>
                <div class="navigation-chain__item navigation-chain__item_active">Добавление разрешения</div>
            </div>
            <div class="content__add-permission permission-add">
                <form method="post" class="permission-add__top">
                    <div class="permission-add__number">
                        <span> Разрешение № {{permission.id}}</span><span class="permission__gap">|</span>Номер в СЭД
                    </div>
                    <input type="text" class="permission__number permission__number_first input" name="first_number" placeholder="Номер" value="{{permission.first_number}}">
                    <span class="permission__slash">/</span>
                    <input type="text" class="permission__number permission__number_second input" name="second_number" placeholder="Номер" value="{{permission.second_number}}">
                    {% if roles.isDispatcher or roles.isAuthor %}
                    <input type="submit" class="permission-add__button input button" name="edit-number" value="Изменить">
                    {% endif %}
                </form>
                <div class="permission-add__list">
                    <div class="permission-add__item">
                        <div class="permission-add__title">
                            1. Выдал {{supervisorOfResponsibleForExecute.lastname}} {{supervisorOfResponsibleForExecute.name}} {{supervisorOfResponsibleForExecute.patronymic}} для выполнения следующих работ:
                        </div>
                        <form method="post" action="http://trans/employee" class="permission-add__supervisor">
                            <input type="text" readonly name="id_type_person" value="5" hidden>
                            {% if roles.isAuthor %}
                            <input type="submit" class="permission-add__button input button" value="Изменить руководителя ответственного исполнителя" name="add-responsible"  style="width: 500px">
                            {% endif %}
                        </form>
                        <div class="permission-add__types">
                            <div class="permission-add__subtitle permission-add__subtitile_typical">
                            </div>
                            {% for current_typical_work in current_typical_works %}
                            <form method="post" class="permission-add__type">
                                <div class="permission-add__typical">
                                    <div class="permission-add__type-name">
                                        - {{current_typical_work.name}}
                                    </div>
                                    <input type="text" name="typical_work_id" class="current_typical_work_id" hidden value="{{current_typical_work.typical_work_id}}" >
                                    {% if roles.isAuthor %}
                                    <span class="icon-clear permission-add__clear current_typical_work_del"></span>
                                    {% endif %}
                                </div>
                                {% if current_typical_work.description != '' %}
                                <div class="permission-add__block">
                                    <textarea readonly class="permission-add__textarea textarea" name="untypical_works" id="untypical_works" cols="30" rows="10" placeholder="Введите нетиповые работы...">{{current_typical_work.description}}</textarea>
                                </div>
                                {% endif %}
                            </form>
                            {% endfor %}
                        </div>
                        <div class="permission-add__subtitle permission-add__subtitile_untypical">
                        </div>
                        {% if permission.untypical_work != '' %}
                        <div class="permission-add__block">
                            <textarea readonly class="permission-add__textarea textarea" name="untypical_works" id="untypical_works" cols="30" rows="10" placeholder="Введите нетиповые работы...">{{permission.untypical_work}}</textarea>
                        </div>
                        {% endif %}
                        {% if roles.isAuthor %}
                        <a href="http://trans/type-work" class="permission-add__button permission-add__button_margin input button" style="width: 350px">Выбрать типы работ</a>
                        {% endif %}
                    </div>
                    <div class="permission-add__item">
                        <div class="permission-add__title">
                            2. В период:
                        </div>
                        <div class="permission-add__block">
                            <div class="permission-add__dates">
                                <div class="permission-add__date">
                                    <div class="permission-add__col">
                                        Дата
                                    </div>
                                    <div class="permission-add__col">
                                        Время начала
                                    </div>
                                    <div class="permission-add__col">
                                        Время окончания
                                    </div>
                                </div>
                                {% for current_date in current_dates %}
                                <div class="permission-add__date">
                                    <div class="permission-add__col">
                                        {{current_date.date}}
                                        <input type="text" hidden value="{{current_date.date}}">
                                    </div>
                                    <div class="permission-add__col">
                                        {{current_date.from_time}}
                                        <input type="text" hidden value="{{current_date.from_time}}">
                                    </div>
                                    <div class="permission-add__col">
                                        {{current_date.to_time}}
                                        <input type="text" hidden value="{{current_date.to_time}}">
                                    </div>
                                </div>
                                {% endfor %}
                            </div>
                            {% if roles.isAuthor %}
                            <a href="http://trans/date" class="permission-add__button input button sticky">Изменить</a>
                            {% endif %}
                        </div>
                    </div>
                    <div class="permission-add__item">
                        <div class="permission-add__title">
                            3. Описание:
                        </div>
                        {% if roles.isAuthor %}
                        <textarea class="permission-add__textarea textarea" name="description" id="description" cols="30" rows="10" placeholder="Введите описание...">{{permission.description}}</textarea>
                        {% else %}
                        <textarea readonly class="permission-add__textarea textarea" name="description" id="description" cols="30" rows="10" placeholder="Введите описание...">{{permission.description}}</textarea>
                        {% endif %}
                    </div>
                    <div class="permission-add__item">
                        <div class="permission-add__title">
                            5. Ответственные за подготовку работ:
                        </div>
                        <div class="permission-add__responsibles">
                            {% for responsible in responsiblesForPreparation %}
                            <div class="permission-add__responsible">
                                <div class="permission-add__name">
                                    {{responsible.lastname}} {{responsible.name}} {{responsible.patronymic}}
                                </div>
                                <input type="text" hidden class="responsible__id" value="{{responsible.user_id}}">
                                <span class="icon-clear permission-add__clear permission__del_user"></span>
                            </div>
                            {% endfor %}
                            {% if roles.isAuthor %}
                            <form action="http://trans/employee" method="post">
                                <input type="text" readonly name="id_type_person" value="2" hidden>
                                <input type="submit" class="permission-add__button input button" value="Добавить ответсвенного за подготовку работ" name="add-responsible"  style="width: 400px">
                            </form>
                            {% endif %}
                        </div>
                    </div>
                    <div class="permission-add__item">
                        <div class="permission-add__title">
                            6. Ответственные за выполнение работ:
                        </div>
                        <div class="permission-add__responsibles">
                            {% for responsible in responsiblesForExecute %}
                            <div class="permission-add__responsible">
                                <div class="permission-add__name">
                                    {{responsible.lastname}} {{responsible.name}} {{responsible.patronymic}}
                                </div>
                                <input type="text" hidden class="responsible__id" value="{{responsible.user_id}}">
                                <span class="icon-clear permission-add__clear permission__del_user"></span>
                            </div>
                            {% endfor %}
                            {% if roles.isAuthor %}
                            <form action="http://trans/employee" method="post">
                                <input type="text" readonly name="id_type_person" value="3" hidden>
                                <input type="submit" class="permission-add__button input button" value="Добавить ответсвенного за проведение работ" name="add-responsible"  style="width: 400px">
                            </form>
                            {% endif %}
                        </div>
                    </div>
                    <div class="permission-add__item">
                        <div class="permission-add__title">
                            7. Ответственный за контроль при производстве работ:
                        </div>
                        <div class="permission-add__responsibles">
                            {% for responsible in responsiblesForControl %}
                            <div class="permission-add__responsible">
                                <div class="permission-add__name">
                                    {{responsible.lastname}} {{responsible.name}} {{responsible.patronymic}}
                                </div>
                                <input type="text" hidden class="responsible__id" value="{{responsible.user_id}}">
                                <span class="icon-clear permission-add__clear permission__del_user"></span>
                            </div>
                            {% endfor %}
                            {% if roles.isAuthor %}
                            <form action="http://trans/employee" method="post">
                                <input type="text" readonly name="id_type_person" value="4" hidden>
                                <input type="submit" class="permission-add__button input button" value="Добавить ответсвенного за контроль при производстве работ" name="add-responsible"  style="width: 500px">
                            </form>
                            {% endif %}
                        </div>
                    </div>
                    <div class="permission-add__item">
                        <div class="permission-add__title">
                            8. Дополнительно:
                        </div>
                        {% if roles.isAuthor %}
                        <textarea class="permission-add__textarea textarea" name="addition" id="addition" cols="30" rows="10" placeholder="Введите дополнительную информацию...">{{permission.addition}}</textarea>
                        {% else %}
                        <textarea readonly class="permission-add__textarea textarea" name="addition" id="addition" cols="30" rows="10" placeholder="Введите дополнительную информацию...">{{permission.addition}}</textarea>
                        {% endif %}
                    </div>
                </div>
                <form method="post" class="permission-add__bottom">
                    <textarea class="permission-add__textarea" name="untypical_works" hidden id="untypical_works_form" cols="30" rows="10" placeholder="Введите нетиповые работы..."></textarea>
                    <textarea class="permission-add__textarea" name="description" hidden id="description_form" cols="30" rows="10" placeholder="Введите описание..."></textarea>
                    <textarea class="permission-add__textarea" name="addition" hidden id="addition_form" cols="30" rows="10" placeholder="Введите дополнительную информацию..."></textarea>
                    {% if roles.isAuthor %}
                    <input type="submit" value="Сохранить" name="update-permission" class="permission-add__button input button">
                    <input type="submit" value="Выгрузить в PDF" class="permission-add__button input button">
                    {% endif %}
                </form>
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="footer__body _container">
            <address class="footer__mail">admin@gmail.com</address>
            <div class="footer__copy">&copy; ПАО "Транснефть" 2022</div>
            <div class="footer__links">
                <a href="https://vk.com/transneftofficial" target="_blank" class="icon-vk footer__link"></a>
                <a href="https://www.facebook.com/TRANSNEFT" target="_blank" class="icon-facebook footer__link"></a>
                <a href="https://twitter.com/transneftRu" target="_blank" class="icon-twitter footer__link"></a>
                <a href="https://www.instagram.com/transneftru/" target="_blank" class="icon-instagram-second footer__link"></a>
                <a href="https://t.me/transneftofficial" target="_blank" class="icon-telegram footer__link"></a>
                <a href="https://invite.viber.com/?g2=AQAJmjbSlaVw3kiGiek7m4%2BbhLm0X01ggdP5DAoiuQUSUvejqFEpi8Rp5Wy6uqI7&lang=ru" target="_blank" class="icon-viber footer__link"></a>
                <a href="https://www.youtube.com/user/transneftru" target="_blank" class="icon-youtube footer__link"></a>
            </div>
        </div>
    </footer>
</div>
{% endif %}
<script src="/public/js/imask.js"></script>
<script src="/public/js/permission_add.js"></script>
</body>
</html>