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
			<div class="content__body _container-main">
                <div class="permission__top">
                    <div class="content__buttons">
                        <form action="" method="post" class="content__form">
                            <input type="submit" class="content__button-checkout content__button-checkout_active" value="Оперативные"  name="operative-permissions">
                        </form>
                        <form action="" method="post" class="content__form">
                            <input type="submit" class="content__button-checkout" value="Архив" name="archive-permissions">
                        </form>
                    </div>
                    <div class="permission__pallete pallete">
                        <div class="pallete__body">
                            <div class="pallete__title">
                                Статусы разрешений
                            </div>
                            <div class="pallete__list">
                                <div class="pallete__item">
                                    <div class="pallete__color pallete__color_violet">

                                    </div>
                                    <div class="pallete__subtitle">
                                        - Создание
                                    </div>
                                </div>
                                <div class="pallete__item">
                                    <div class="pallete__color pallete__color_beige">

                                    </div>
                                    <div class="pallete__subtitle">
                                        - Согласование
                                    </div>
                                </div>
                                <div class="pallete__item">
                                    <div class="pallete__color pallete__color_blue">

                                    </div>
                                    <div class="pallete__subtitle">
                                        - Утверждено
                                    </div>
                                </div>
                                <div class="pallete__item">
                                    <div class="pallete__color pallete__color_green">

                                    </div>
                                    <div class="pallete__subtitle">
                                        - Открыто
                                    </div>
                                </div>
                                <div class="pallete__item">
                                    <div class="pallete__color pallete__color_yellow">

                                    </div>
                                    <div class="pallete__subtitle">
                                        - Приостановлено
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="filter-content__funcs">
                    <div class="input button button-content filter">Фильтры</div>
					<form method="post" class="content-search">
						<input type="text" class="input input-search" name="search_info" value="{{search_info}}" placeholder="Поиск...">
						<span class="icon-search"></span>
						<input type="submit" hidden name="search_permission" class="permission-search">
					</form>
                    {% if roles.isAuthor %}
                    <form action="http://trans/permission/add" method="post">
                        <input type="submit" class="input button button-content" name="create-permission" value="Создать">
                    </form>
                    <form action="" method="post">
                        <input type="submit" name="create-permission-by"  class="input button button-content permission-event" value="Создать на основе">
                        <input type="text" class="row-id-process" hidden name="id" required id="">
                    </form>
                    {% endif %}
					<form action="" method="post">
						<input type="submit" name="edit-permission" class="input button button-content permission-event" value="Править">
						<input type="text" class="row-id-process" hidden name="id" required id="">
					</form>
                    {% if roles.isAuthor %}
                    <form action="" method="post">
                        <input type="submit" name="del-permission" class="input button button-content permission-event" value="Удаление">
                        <input type="text" class="row-id-process" hidden name="id" required id="">
                    </form>
                    {% endif %}
                    {% if roles.isDispatcher %}
                    <div class="permission__block-button">
                        <a class="input button button-content permission-event">Открыть</a>
                        <input type="text" class="row-id-process" hidden name="id" required id="">
                        <div class="permission__status permission-status">
                            <form action="" method="post" class="permission-status__body">
                                <div class="permission-status__subtitle">
                                    Фактическая дата открытия разрешения:
                                </div>
                                <input type="text" name="date" required="required" class="table-col__input date-mask input date permission-status__date" pattern="^(?:(?:31(\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$">
                                <div class="permission-status__subtitle">
                                    Фактическое время открытия разрешения:
                                </div>
                                <input type="text" name="time" required="required" class="table-col__input time-mask input permission-status__time" pattern="^([0-1][0-9]|2[0-4]):[0-5][0-9]$">
                                <div class="permission-status__subtitle">
                                    Комментарий:
                                </div>
                                <textarea class="permission-status__comment input textarea" name="comment" id="" cols="30" rows="10"></textarea>
                                <input type="text" readonly hidden class="permission-status__id">
                                <input type="submit" name="open-permission" class="permission-status__button permission-status__ok input button" value="Ок">
                                <a class="permission-status__button permission-status__cancel input button">Отменить</a>
                            </form>
                        </div>
                    </div>
                    {% endif %}
                    {% if roles.isDispatcher %}
                    <div class="permission__block-button">
                        <a class="input button button-content permission-event">Приостановить</a>
                        <input type="text" class="row-id-process" hidden name="id" required id="">
                        <div class="permission__status permission-status">
                            <form action="" method="post" class="permission-status__body">
                                <div class="permission-status__subtitle">
                                    Фактическая дата приостановки разрешения:
                                </div>
                                <input type="text" name="date" required="required" class="table-col__input date-mask input date permission-status__date" pattern="^(?:(?:31(\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$">
                                <div class="permission-status__subtitle">
                                    Фактическое время приостановки разрешения:
                                </div>
                                <input type="text" name="time" required="required" class="table-col__input time-mask input permission-status__time" pattern="^([0-1][0-9]|2[0-4]):[0-5][0-9]$">
                                <div class="permission-status__subtitle">
                                    Комментарий:
                                </div>
                                <textarea class="permission-status__comment input textarea" name="comment" id="" cols="30" rows="10">
								</textarea>
                                <input type="text" readonly hidden class="permission-status__id">
                                <input type="submit" name="pause-permission" class="permission-status__button permission-status__ok input button" value="Ок">
                                <a class="permission-status__button permission-status__cancel input button">Отменить</a>
                            </form>
                        </div>
                    </div>
                    {% endif %}
                    {% if roles.isDispatcher %}
                    <div class="permission__block-button">
                        <a class="input button button-content permission-event">Закрыть</a>
                        <input type="text" class="row-id-process" hidden name="id" required id="">
                        <div class="permission__status permission-status">
                            <form action="" method="post" class="permission-status__body">
                                <div class="permission-status__subtitle">
                                    Фактическая дата закрытия разрешения:
                                </div>
                                <input type="text" name="date" required="required" class="table-col__input date-mask input date permission-status__date" pattern="^(?:(?:31(\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$">
                                <div class="permission-status__subtitle">
                                    Фактическое время закрытия разрешения:
                                </div>
                                <input type="text" name="time" required="required" class="table-col__input time-mask input permission-status__time" pattern="^([0-1][0-9]|2[0-4]):[0-5][0-9]$">
                                <div class="permission-status__subtitle">
                                    Комментарий:
                                </div>
                                <textarea class="permission-status__comment input textarea" name="comment" id="" cols="30" rows="10">
								</textarea>
                                <input type="text" readonly hidden class="permission-status__id">
                                <input type="submit" name="close-permission" class="permission-status__button permission-status__ok input button" value="Ок">
                                <a class="permission-status__button permission-status__cancel input button">Отменить</a>
                            </form>
                        </div>
                    </div>
                    {% endif %}
				</div>
				<div class="content__filter filter-content">
					<form method="post" class="filter-content__block">
						<div class="filter-content__list">
                            {% if roles.isAuthor %}
                            <div class="filter-content__item">
                                <div class="filter-content__subtitle">
                                    Периоды работ
                                </div>
                                <div class="filter-content__date date-filter">
                                    <div class="date-filter__block">
                                        <span class="filter-content__span">Начальная дата</span><input type="date" value="{{date_start}}" name="date_start">
                                    </div>
                                    <div class="date-filter__block">
                                        <span class="filter-content__span">Конечная дата</span> <input type="date" value="{{date_end}}" name="date_end">
                                    </div>
                                </div>
                            </div>
                            {% endif %}
                            <div class="filter-content__item">
                                <div class="filter-content__subtitle">
                                    Статусы разрешений
                                </div>
                                <div class="filter-content__status-list">
                                    {% for status in statuses %}
                                    <div class="filter-content__status-item">
                                        {% if status.active == true %}
                                        <input id="{{status.id}}" class="filter-content__status-id" type="checkbox" checked="checked">
                                        {% else %}
                                        <input id="{{status.id}}" class="filter-content__status-id" type="checkbox">
                                        {% endif %}
                                        <label for="{{status.id}}">{{status.name}}</label>
                                    </div>
                                    {% endfor %}
                                    <input type="text" readonly name="statuses" hidden class="filter-content__statuses">
                                </div>
                            </div>
							<div class="filter-content__item">
								<div class="filter-content__buttons">
                                    <input type="submit" class="input button filter-content__button apply-filter" name="filter" value="Применить">
									<div class="input button filter-content__button close-filter">Закрыть</div>
								</div>
							</div>
						</div>
					</form>
				</div>
                {% if permissions|length == 0 %}
                    <div class="table_error_message">{{message}}</div>
                {% else %}
				<div class="content__table">
					<div class="content__table table-content table-permission">
						<div class="table-content__row table-content__row_head table-permission__row_head">
                            <div class="table-content__col table-content__head table-permission__head"></div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__id">№</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__number">№ в СЭД</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__date">Дата создания</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__status">Статус</div>
                            {% if roles.isReplacementEngineer or roles.isInspectingEngineer or roles.isDispatcher %}
                            <div class="table-content__col table-content__head table-permission__head table-permission__masking">Маскирование</div>
                            {% endif %}
                            <div class="table-content__col table-content__head table-permission__head table-permission__subdivision">Подразделение</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__person">Ответственные за подготовку работ</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__person">Ответственные за выполнение работ</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__person">Ответственные за контроль при производстве работ</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__period">Периоды работ</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__text">Виды работ</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__text">Описание</div>
                            <div class="table-content__col table-content__head table-permission__head table-permission__text">Дополнительно</div>
						</div>
                        {% for permission in permissions %}
                        <input type="text" readonly value="{{permission.color}}" hidden class="table-permission__background">
						<div class="table-content__row table-row table-permission__row">
                            <div class="table-content__col table-col table-permission__col col-check">
                              <input type="checkbox" class="input-choice input-choice-permission">
                            </div>
                            <div class="table-content__col table-col table-permission__col table-permission__id">
                                {{permission.id}}
                            </div>
							<div class="table-content__col table-col table-permission__col table-permission__number">
                                {{permission.number}}
							</div>
							<div class="table-content__col table-col table-permission__col table-permission__date">
                                {{permission.date_create}}
							</div>
							<div class="table-content__col table-col table-permission__col table-permission__status">
                                {{permission.status_name}}
							</div>

                             <!-- Максирование -->

                            {% if roles.isReplacementEngineer or roles.isInspectingEngineer  or roles.isDispatcher %}
                            <div class="table-content__col table-col table-permission__col-mask table-permission__masking-block">
								<div class="table-content__row table-content__row_head table-permission__row_head">
									<div class="table-content__head table-permission__protection">Защиты</div>
									<div class="table-content__head table-permission__mask-status">М</div>
									<div class="table-content__head table-permission__mask-status">Д</div>
									<div class="table-content__head table-permission__mask-status">ПМ</div>
									<div class="table-content__head table-permission__mask-status">ПД</div>
								</div>
                                {% set i = 0 %}
                                <form action="" method="post">
                                {% for protection in protections %}
                                {% if protection.permissionid ==  permission.id %}
                                {% set i = i + 1 %}
								<div class="table-content__row table-permission__row-mask table-content__row-main">
									<div class="table-col table-permission__protection table-permission__item-mask protection-{{i}}">
                                        {{protection.protection_name}}
									</div>
                                    {% if protection.masking == true %}
									<div class="table-col table-permission__mask-status table-permission__item-mask">
										<label class="check-mask">
											<input type="checkbox" class="check-mask__input masking-{{i}}" name="masking-{{i}}" hidden checked>
											<span class="check-mask__span"></span>
										</label>
									</div>
                                    {% else %}
                                    <div class="table-col table-permission__mask-status table-permission__item-mask">
										<label class="check-mask">
											<input type="checkbox" class="check-mask__input masking-{{i}}" name="masking-{{i}}" hidden>
											<span class="check-mask__span"></span>
										</label>
									</div>
                                    {% endif %}
                                    {% if protection.unmasking == true %}
									<div class="table-col table-permission__mask-status table-permission__item-mask">
										<label class="check-mask">
											<input type="checkbox" class="check-mask__input unmasking-{{i}}" name="unmasking-{{i}}" hidden checked>
											<span class="check-mask__span"></span>
										</label>
									</div>
                                    {% else %}
                                    <div class="table-col table-permission__mask-status table-permission__item-mask">
										<label class="check-mask">
											<input type="checkbox" class="check-mask__input unmasking-{{i}}" name="unmasking-{{i}}" hidden>
											<span class="check-mask__span"></span>
										</label>
									</div>
                                    {% endif %}
                                    {% if protection.check_masking == true %}
									<div class="table-col table-permission__mask-status table-permission__item-mask">
										<label class="check-mask" >
											<input type="checkbox" class="check-mask__input check_masking-{{i}}" name="check_masking-{{i}}" hidden checked>
											<span class="check-mask__span"></span>
										</label>
									</div>
                                    {% else %}
                                    <div class="table-col table-permission__mask-status table-permission__item-mask">
										<label class="check-mask" >
											<input type="checkbox" class="check-mask__input check_masking-{{i}}" name="check_masking-{{i}}" hidden>
											<span class="check-mask__span"></span>
										</label>
									</div>
                                    {% endif %}
                                    {% if protection.check_unmasking == true %}
									<div class="table-col table-permission__mask-status table-permission__item-mask">
										<label class="check-mask">
											<input type="checkbox" class="check-mask__input check_unmasking-{{i}}" name="check_unmasking-{{i}}" hidden checked >
											<span class="check-mask__span"></span>
										</label>
									</div>
                                    {% else %}
                                    <div class="table-col table-permission__mask-status table-permission__item-mask">
										<label class="check-mask">
											<input type="checkbox" class="check-mask__input check_unmasking-{{i}}" name="check_unmasking-{{i}}" hidden>
											<span class="check-mask__span"></span>
										</label>
									</div>
                                    {% endif %}
								</div>
                                {% endif %}
                                {% endfor %}
                                    <input type="submit" name="submit-masking" class="input button button-content permission-event" value="Замаскировать">
                                 </form>
							</div>
                            {% endif %}

                            <!--  -->

							<div class="table-content__col table-col table-permission__col table-permission__subdivision">
                                {{permission.subdivision_name}}
                            </div>
							<div class="table-content__col table-col table-permission__col table-permission__person">
                                {% for responsible in responsiblesForPreparation %}
                                    {% if responsible.permission_id == permission.id %}
                                        <div class="table-permission__subname">
                                            {{responsible.lastname}} {{responsible.name}} {{responsible.patronymic}}
                                        </div>
                                    {% endif %}
                                {% endfor %}
							</div>
                            <div class="table-content__col table-col table-permission__col table-permission__person">
                                {% for responsible in responsiblesForExecute %}
                                {% if responsible.permission_id == permission.id %}
                                <div class="table-permission__subname">
                                    {{responsible.lastname}} {{responsible.name}} {{responsible.patronymic}}
                                </div>
                                {% endif %}
                                {% endfor %}
                            </div>
                            <div class="table-content__col table-col table-permission__col table-permission__person">
                                {% for responsible in responsiblesForControl %}
                                {% if responsible.permission_id == permission.id %}
                                <div class="table-permission__subname">
                                    {{responsible.lastname}} {{responsible.name}} {{responsible.patronymic}}
                                </div>
                                {% endif %}
                                {% endfor %}
                            </div>
                            <div class="table-content__col table-col table-permission__col table-permission__period">
                                {% for date in dates %}
                                {% if date.permissionid == permission.id %}
                                <div class="table-permission__subname">
                                    {{date.date}} {{date.from_time}}-{{date.to_time}}
                                </div>
                                {% endif %}
                                {% endfor %}
                            </div>
                            <div class="table-content__col table-col table-permission__col table-permission__text">
                                {% for work in typical_works %}
                                {% if work.permission_id == permission.id %}
                                <div class="table-permission__subname">
                                    {{work.name}}
                                </div>
                                {% endif %}
                                {% endfor %}
                            </div>
                            <div class="table-content__col table-col table-permission__col table-permission__text">
                                {{permission.description}}
                            </div>
                            <div class="table-content__col table-col table-permission__col table-permission__text">
                                {{permission.addition}}
                            </div>
							<input type="text" class="row-id" name="id" hidden readonly value="{{permission.id}}">
						</div>
                        {% endfor %}
					</div>
				</div>
                {% endif %}
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
        <script src="/public/js/imask.js"></script>
        <script src="/public/js/functions.js"></script>
		<script src="/public/js/permission.js"></script>
	</body>
</html>