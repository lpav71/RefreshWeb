<template>
    <div class="center-plus-right">
        <div style="width: 1438px;height: 815px;">
            <div v-show="clientCard" style="width: 1438px;height: 272px;display: flex;justify-content: space-between;">
                <div class="graphic">
                    <div id="line-chart">
                        <GChart
                            ref="workload"
                            :data="chartData2"
                            :options="chartOptions2"
                            type="LineChart"
                        />
                    </div>
                </div>
                <div class="active-bron">
                    <div style="width: 430px;margin-top: 10px;color: var(--standart-gray);">
                        <i class="fa fa-book-open"></i><span style="font-size: 13px;margin-left: 11px;">Активные бронирования ПК</span></div>
                    <div class="active-bron-buttons">
                        <div v-for="(c, i) in clientList" :class="{'mt-3': (i !== 0 && i !== 1)}" class="active-bron2">
                            <div class="active-bron2" @click="bModal(i)">
                                <div class="btn btn-success ms-3 mb-1 timebtn"><span class="time">{{ c.time_stop }}</span></div>
                                <div class="active-bron2-right">
                                    <span class="active-bron2-text">{{ c.login }}</span><span class="tasks-text-2">{{ c.map_comp_id }} компьютер</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="{fullscreen: !clientCard}" @mousemove="move" @mouseup="mmup">
                <div :style="{marginTop: managerMarginTop + 'px'}" class="all-buttons">
                    <div style="display: flex;align-items: center;">
                        <i class="fa fa-delicious fs-2" style="color: var(--standart-color);"></i><span class="panel-manager">Панель управления</span>
                        <button class="btn btn-success me-1"><span style="color: var(--standart-color);" @click="generalMap">Общая карта</span>
                        </button>
                        <button v-for="(zone, index) in zones" :class="[{'button-active': zones[index].active}]" class="btn btn-success me-1" @click="changeZone(index)">
                            <span>{{ zone.name }}</span></button>
                    </div>
                    <div style="display: flex;align-items: center;">
                        <div v-show="permissions.create_zone" class="btn btn-success me-1" @click="addZone">Добавить зону</div>
                        <div v-show="permissions.create_pc" class="btn btn-success me-1" @click="addBox">
                            <i class="fa fa-plus fs-5" style="position: relative;top: 3px;"></i></div>
                        <div class="btn btn-success me-1" style="width: 40px;" @click="lockButton">
                            <img v-if="!permissionMove" alt="" src="img/lock-close.svg"><img v-if="permissionMove" alt="" src="img/lock-open.svg">
                        </div>
                        <div class="btn btn-success me-1" @click="switchClientCard"><span>Клиентская карта</span></div>
                    </div>
                </div>
                <div :style="{height: manegerHeight + 'px'}" class="manager outbox">
                    <div v-for="(position, index) in positions" :class="{zoneBorder: position.mainborder}" :style="{
                        top: position.top + 'px',
                        left: position.left + 'px', width: boxWidth + 'px',
                        height: boxHeight + 'px',
                        background: position.bg,
                    }" :title="position.user_id" class="box" role="button"
                         @mousedown="mdown($event, index)" @contextmenu.prevent="contextMenu($event, index)">
                        {{ index + 1 }}
                        <div v-show="position.sos" class="sos"></div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="clientCard" style="width: 323px;height: 815px;">
            <div class="shift-close" style="display: flex;align-items: center;justify-content: center;">
                <div style="width: 149px;height: 44px;display: flex;justify-content: center;align-items: center;">
                    <i class="fa fa-clock" style="color: var(--standart-gray);font-size: 21px;"></i>
                    <div style="width: 130px;height: 40px;display: flex;flex-direction: column;">
                        <span style="color: var(--standart-gray);text-align: center;font-size: 15px;">{{ shiftStatus }}</span><span style="color: var(--standart-gray);text-align: center;font-size: 15px;">{{ time }}</span>
                    </div>
                </div>
                <button v-show="permissions.balance_money || permissions.balance_bonus" class="btn btn-success button-shift-close" @click="switchShift">
                    <span style="font-size: 12px;">{{ shiftOpenClose }}</span></button>
            </div>
            <div class="cash">
                <div class="nal-card"><span style="color: var(--standart-gray);">Наличные/карта</span>
                    <div style="width: 250px;height: 32px;background: #122834;border-radius: 10px;margin-top: 5px;display: flex;align-items: center;justify-content: space-between;padding-right: 15px;">
                        <div style="width: 179px;height: 32px;background: var(--standart-green);border-radius: 10px;display: flex;justify-content: flex-start;align-items: center;padding-left: 15px;">
                            <span>{{ Number(nalic).toFixed(2) }}</span></div>
                        <span style="color: var(--standart-gray);">{{ Number(card).toFixed(2) }}</span>
                    </div>
                </div>
                <div class="nal-card"><span style="color: var(--standart-gray);">Товары/услуги</span>
                    <div style="width: 250px;height: 32px;background: #122834;border-radius: 10px;margin-top: 5px;display: flex;align-items: center;justify-content: space-between;padding-right: 15px;">
                        <div style="width: 179px;height: 32px;background: var(--standart-green);border-radius: 10px;display: flex;justify-content: flex-start;align-items: center;padding-left: 15px;">
                            <span>{{ Number(goods).toFixed(2) }}</span></div>
                        <span style="color: var(--standart-gray);">{{ Number(services).toFixed(2) }}</span>
                    </div>
                </div>
                <div class="chart_1">
                    <GChart :data="chartData" :options="chartOptions" :settings="{packages: ['corechart']}" type="PieChart"/>
                </div>
            </div>
            <div class="tasks">
                <span style="color: var(--standart-gray);display: block;position: relative;top: 20px;left: 40px;width: 143px;">Список задач</span>
                <div class="task-list pe-2">

                    <div v-for="(t,i) in tasks" class="task">
                        <div class="task-1">
                            <div :style="{background: t.color}" class="intask">
                                <span style="color: var(--standart-gray);font-size: 10px;" @click="editTask(i)">{{ t.create_dt }}</span></div>
                            <span v-if="t.descript_admin !== null" :data-bs-title="t.descript_admin" class="tasks-text" data-bs-custom-class="custom-tooltip" data-bs-placement="top" data-bs-toggle="tooltip" style="font-size: 10px;margin-left: 7px;">{{ t.descript_admin.length > maxLenghtText ? t.descript_admin.slice(0, maxLenghtText) + '...' : t.descript_admin }}</span>
                        </div>
                        <i class="fa fa-caret-right" style="color: var(--standart-gray);margin-right: 10px;"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div v-show="contextMenuShow" id="context" :style="{left: contextMenuLeft + 'px', top: contextMenuTop + 'px', height: contextMenuHeight + 'px'}" class="context-menu">
        <div v-show="contextMenuShowHeader" class="userIdHeader" @click="contextMenuUserIdClick">{{ contextMenuUserId }}<i class="fa fa-caret-right"></i>
        </div>
        <div @click="poweron">Включить</div>
        <div @click="poweroff">Выключить</div>
        <div @click="reboot">Перезагрузить</div>
        <div @click="sos">SOS</div>
    </div>
    <div v-show="contextMenuAdd" id="userIdHeaderMenu" :style="{left: contextMenuLeft + 210 + 'px', top: contextMenuTopAdd + 'px', height: contextMenuHeightAdd + 'px'}" class="context-menu">
        <div>Продажа</div>
        <div @click="additionBalance">Пополнение</div>
        <div>Штраф</div>
        <div>Смена места</div>
        <div @click="sendMessageFromMenu">Отправить сообщение</div>
        <div>Отправить уведомление</div>
        <div>История бронирований</div>
        <div>История пополнений</div>
        <div>История событий</div>
        <div>Выход из сессии</div>
    </div>


    <!-- Модальное окно -->
    <div id="shiftModal" aria-hidden="true" aria-labelledby="shiftModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content shiftModal">
                <div class="modal-header">
                    <div class="shiftModal close-cross"></div>
                    <h5 id="shiftModalLabel" class="modal-title">{{ modalHeader }}</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <span class="waiting">Ждите. Операция выполняется...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="addZoneModal" aria-hidden="true" aria-labelledby="addZoneModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content addZoneModal">
                <div class="modal-header">
                    <h5 id="addZoneModalLabel" class="modal-title">Добавить группу ПК</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <input v-model="zoneName" class="input_zone" placeholder="Введите название зала" type="text">
                    <div class="modal-footer">
                        <button class="btn btn-success" type="button" @click="zoneSave">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="bookingModal" aria-hidden="true" aria-labelledby="bookingModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="bookingModalLabel" class="modal-title">Информация о бронировании</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="main_modal">
                        <div class="info_modal" style="margin-top: 13px;">
                            <div class="table-responsive">
                                <table class="table table-borderless user_info_modal">
                                    <tbody>
                                    <tr>
                                        <td><span class="name_modal">Пользователь: </span><span class="value_modal">{{ currentClient.login }}</span>
                                        </td>
                                        <td>
                                            <span class="name_modal">Компьютер: </span><span class="value_modal">{{ currentClient.zone }} {{ currentClient.map_comp_id }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Дата: </span><span class="value_modal">{{ currentClient.date }}</span></td>
                                        <td><span class="name_modal">Время: </span><span class="value_modal">{{ currentClient.time_start }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Тариф: </span><span class="value_modal">{{ currentClient.tariff }}</span></td>
                                        <td>
                                            <span class="name_modal">Источник: </span><span class="value_modal">booking.refresh-software.ru/id3456789</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Оплата: </span><span class="value_modal">Произведена</span></td>
                                        <td><span class="name_modal">Метод оплаты: </span><span class="value_modal">Банковская карта (онлайн)</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="margin-top: 20px;"><span>Контактная информация</span>
                            <div class="contact_modal">
                                <table class="table table-borderless user_info_modal">
                                    <tbody>
                                    <tr>
                                        <td><span class="name_modal">Номер телефона: </span><span class="value_modal">{{ currentClient.phone }}</span>
                                        </td>
                                        <td>
                                            <span class="name_modal">E-mail: </span><span class="value_modal">{{ currentClient.email }} {{ currentClient.map_comp_id }}</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="cancelBooking">Отмена бронирования</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="messageModal0" aria-hidden="true" aria-labelledby="messageModal0Label" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="messageModal0Label" class="modal-title">Сообщение</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <textarea v-model="messageText" spellcheck="false"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="sendMessage">Отправить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="topBalanceModal" aria-hidden="true" aria-labelledby="topBalanceModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="topBalanceModalLabel" class="modal-title" style="color: white">Пополнение баланса пользователя
                        <span style="color: #0d6efd">{{ login }}</span></h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">

                    <div class="main">
                        <div class="div_1"><span>Сумма</span><input v-model.number="summa" class="input_1 rounded" maxlength="10" type="number"/>
                        </div>
                        <div class="div_2">
                            <div class="div_3"><span>Способы оплаты</span>
                                <div v-show="permissions.balance_money" class="div_4">
                                    <div class="form-check form-check-reverse text-start">
                                        <input id="formCheck-1" v-model="pay" class="form-check-input check-1" name="payment" style="opacity: 0;position: absolute;z-index: -1;" type="radio" value="cash"/><label class="form-check-label label-1" for="formCheck-1">Наличные</label>
                                    </div>
                                </div>
                                <div v-show="permissions.balance_money" class="div_4">
                                    <div class="form-check form-check-reverse text-start">
                                        <input id="formCheck-3" v-model="pay" class="form-check-input check-1" name="payment" style="opacity: 0;position: absolute;z-index: -1;" type="radio" value="card"/><label class="form-check-label label-1" for="formCheck-3">Карта</label>
                                    </div>
                                </div>
                                <div v-show="permissions.balance_bonus" class="div_4">
                                    <div class="form-check form-check-reverse text-start">
                                        <input id="formCheck-2" v-model="pay" class="form-check-input check-1" name="payment" style="opacity: 0;position: absolute;z-index: -1;" type="radio" value="bonus"/><label class="form-check-label label-1" for="formCheck-2">Бонусная валюта</label>
                                    </div>
                                </div>
                            </div>
                            <div class="div_3"><span>Чек</span>
                                <div class="div_4">
                                    <div class="form-check form-check-reverse text-start">
                                        <input id="formCheck-4" v-model="chek" class="form-check-input check-2" name="chek" style="opacity: 0;position: absolute;z-index: -1;" type="radio" value="post"/><label class="form-check-label label-1" for="formCheck-4">Отправить на почту</label>
                                    </div>
                                </div>
                                <div class="div_4">
                                    <div class="form-check form-check-reverse text-start">
                                        <input id="formCheck-5" v-model="chek" class="form-check-input check-2" name="chek" style="opacity: 0;position: absolute;z-index: -1;" type="radio" value="print"/><label class="form-check-label label-1" for="formCheck-5">Печатать</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="div_1">
                            <div class="div_1"><span>Комментарий к платежу</span><input v-model="comment" class="input_1 rounded" type="text"/></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                    <button :disabled="payTextDisabled" class="btn btn-success" type="button" @click="payment">Оплата</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Изменить -->
    <div id="editTaskModal" aria-hidden="true" aria-labelledby="addTaskModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="addTaskModalLabel" class="modal-title">Изменить задание</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body" style="padding: 17px;">
                    <div class="block" style="margin-top: 0">
                        <span>Описание</span>
                        <input v-model="descript_admin" class="input" placeholder="Протереть столы" type="text"/>
                    </div>
                    <div class="block">
                        <span>Плановая дата публикации задания</span>
                        <input id="start" v-model="datePublic" class="input" type="text" @click="calendarShowStart"/>
                    </div>
                    <div class="block">
                        <span>Срок выполнения</span>
                        <select v-model="days" class="input">
                            <option v-for="(d,i) in deadLineDay" :value="d">{{ d }} дн.</option>
                        </select>
                        <select v-model="hours" class="input">
                            <option v-for="(d,i) in deadLineHours" :value="d">{{ d }} ч.</option>
                        </select>
                    </div>
                    <div class="block">
                        <span>Исполнитель</span>
                        <select v-model="executor" class="input">
                            <optgroup label="Выберите исполнителя">
                                <option v-for="u in users" :value="u.id">{{ u.name }}</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="saveEditTask">Сохранить</button>
                </div>
            </div>
        </div>
        <calendar ref="calandarStart" style:="position: absolute" @item-selected="calendarSelectStart"></calendar>
    </div>

    <!-- Уведомление -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" aria-atomic="true" aria-live="assertive" class="toast" role="alert">
            <div class="toast-header">
                <strong class="me-auto">Уведомление</strong>
                <button aria-label="Закрыть" class="btn-close btn-close-white" data-bs-dismiss="toast" type="button"></button>
            </div>
            <div class="toast-body">
                У вас {{ count }} новых задач
            </div>
        </div>
    </div>

    <message ref="message"></message>
    <system-message ref="sysMessage"></system-message>

</template>

<script>
import {GChart} from "vue-google-charts";
import {createLog} from '../logger';


var dragObject  = false; //Смещение объекта запрещено
var offsetX     = 0; //Смещение мышки внутри перемещаемого элемента по X
var offsetY     = 0; //Смещение мышки внутри перемещаемого элемента по Y
var globalIndex = 0;
export default {
    components: {
        GChart
    },
    props     : ['name', 'club', 'userData'],
    data() {
        return {
            club      : {},
            height    : 0, //Высота окна браузера
            width     : 0, //Ширина окна браузера
            widthout  : 0, //Ширина окна outbox
            lowout    : 0, //Низ окна outbox
            otstupLeft: 15, //Отступ слева окна outbox
            otstupTop : 0, //Отступ сверху окна outbox
            boxHeight : 35, //Высота подвижного кубика
            boxWidth  : 35, //Ширина подвижного кубика
            boxColor  : '#6FC8CC',
            positions : [],
            element   : {},
            //---------------------
            zones          : [],
            active         : false,
            zone           : -1,
            nalic          : 0,
            card           : 0,
            goods          : 0,
            services       : 0,
            time           : null,
            shiftStatus    : "Начало смены",
            shiftOpenClose : 'Закрыть смену',
            shiftStatusOpen: true, //Смена открыта - значит true
            modal          : null,
            topBalanceModal: null,
            bookingModal   : null,
            addZoneModal   : null,
            timerId        : null,
            modalHeader    : "Открытие смены",
            //------------------------
            clientList      : [],
            currentClient   : {},
            zoneName        : '',
            uData           : {},
            tasks           : null,
            permissions     : {},
            permissionMove  : true,
            lock            : false,
            index           : null,
            mapTable        : [],
            messageModal    : null,
            messageText     : '',
            messageIp       : '',
            clientCard      : true,
            manegerHeight   : 429,
            managerMarginTop: 52,

            chartData   : [
                ['Finance', 'Quantity'],
                ['Наличные', 11],
                ['Бонусы', 2]
            ],
            chartOptions: {
                pieHole        : 0.4,
                backgroundColor: '#183F52',
                color          : '#ffffff',
                height         : '120',
                width          : '270',
                chart          : {
                    title: 'Company Performance'
                },
                legend         : {
                    position : 'right',
                    maxLines : 3,
                    textStyle: {
                        color: '#ffffff',
                    }
                },
                slices         : {
                    0: {color: '#01B253'},
                    1: {color: '#FA4C4C'}
                }
            },

            chartData2   : [
                ['Year', 'Количество компьютеров'],
                ['0', 0],
            ],
            chartOptions2: {
                title          : 'Загруженность клуба',
                curveType      : 'function',
                backgroundColor: '#183F52',
                color          : '#ffffff',
                height         : '272',
                chartArea      : {width: '85%'},
                legend         : {
                    position : 'bottom',
                    maxLines : 3,
                    textStyle: {
                        color: '#ffffff',
                    }
                },
                vAxis          : {
                    textStyle: {
                        color: '#FFFFFF'
                    },
                    gridlines: {
                        color: '#939393'
                    }
                },
                hAxis          : {
                    textStyle: {
                        color: '#FFFFFF'
                    },
                    gridlines: {
                        color: '#aaaaaa'
                    }
                },
                titleTextStyle : {
                    color: '#FFFFFF'
                }
            },

            contextMenuShow      : false,
            contextMenuShowHeader: false,
            contextMenuLeft      : 100,
            contextMenuTop       : 100,
            contextMenuTopAdd    : 100,
            contextMenuHeight    : 175,
            contextMenuHeightAdd : 350,
            contextMenuUserId    : 0,
            contextMenuAdd       : false,
            contextMenuData      : {},

            login           : '',
            pay             : '',
            chek            : '',
            summa           : 0,
            comment         : '',
            maxLenghtText   : 15,
            toastLiveExample: null,
            toast           : null,
            count           : 0,

            editTaskModal : null,
            days          : 0,
            hours         : 0,
            executor      : '',
            descript_admin: '',
            datePublic    : '',
            id_task       : 0,
            admin_id      : 0,
            users         : [],
            deadLineDay   : [],
            deadLineHours : [],
        }
    },
    methods: {
        async getAllBookingsPerDay() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.club.id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch(`api/booking/get-all`, requestOptions);
            if (response.ok) {
                var result = await response.json();
                for (let i = 0; i < result.length; i++) {
                    var str = i.toString();
                    this.$refs.workload.data.push([str, result[i]]);
                }
            }
        },
        editTask(i) {
            this.descript_admin = this.tasks[i].descript_admin;
            this.datePublic     = this.tasks[i].create_dt;
            this.admin_id       = this.tasks[i].admin_id;
            var executor_id     = this.tasks[i].employ;
            this.users.forEach((item, index) => {
                if (item.id == executor_id) {
                    this.executor = item.id;
                }
            });
            this.id_task = this.tasks[i].id;
            this.editTaskModal.show();
        },
        async saveEditTask() {
            this.editTaskModal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id_task", this.id_task);
            urlencoded.append("date_public", this.datePublic);
            urlencoded.append("days", this.days);
            urlencoded.append("hours", this.hours);
            urlencoded.append("executor", this.executor);
            urlencoded.append("club_id", this.club.id);
            urlencoded.append("admin_id", this.admin_id);
            urlencoded.append("descript_admin", this.descript_admin);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/save/edit", requestOptions);
            if (response.ok) {
                this.getTasks();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getUsers() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.club.id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/users", requestOptions);
            if (response.ok) {
                this.users = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        additionBalance() {
            this.hideContextMenu();
            this.topBalanceModal.show();
        },
        async getDiagramData() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.club.id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/diagram/calc", requestOptions);
            if (response.ok) {
                var result           = await response.json();
                this.chartData[1][1] = ~~result.total_cash;
                this.chartData[2][1] = ~~result.bonus;
            } else {
                this.$refs.message.modal.show();
            }
        },
        switchClientCard() {
            this.clientCard = !this.clientCard;
            if (this.clientCard) {
                this.manegerHeight    = 429;
                this.managerMarginTop = 52;
            } else {
                this.manegerHeight    = 790;
                this.managerMarginTop = 0;
                this.lock             = 'fa fa-lock fs-5';
                this.permissionMove   = false;
            }

        },
        tooltipSetup() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList        = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        },
        async getPermissions() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.uData.club_id);
            urlencoded.append("user_id", this.uData.id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user/getpermissions", requestOptions);
            if (response.ok) {
                this.permissions = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        lockButton() {
            this.permissionMove = !this.permissionMove;
            if (this.permissionMove)
                this.lock = 'fa fa-unlock fs-5';
            if (!this.permissionMove)
                this.lock = 'fa fa-lock fs-5';
        },
        generalMap() {
            this.zones.forEach(function (item) {
                item.active = false;
            });
            for (var i = 0; i < this.positions.length; i++) {
                this.positions[i].mainborder = false;
            }
        },
        addZone() {
            this.addZoneModal.show();
        },
        async zoneSave() {
            this.addZoneModal.hide();
            var club_id = JSON.parse(this.$props.club).id;

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", club_id);
            urlencoded.append("zone_name", this.zoneName);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/zone/add", requestOptions);
            if (response.ok) {
                var result = await response.json();
                this.zones.push(result);
                var data = {
                    'zone_name': this.zoneName
                };
                createLog(JSON.stringify(data), 'Добавление зоны', 'place', this.uData.id);
            } else {
                this.$refs.message.modal.show();
            }
        },
        async changeStatus(id) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id", id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/booking/cancel", requestOptions);
            if (response.ok) {
                var data = {
                    'login'     : this.currentClient.login,
                    'zone'      : this.currentClient.zone,
                    'date'      : this.currentClient.date,
                    'time_start': this.currentClient.time_start,
                    'tariff'    : this.currentClient.tariff
                }
                createLog(JSON.stringify(data), 'Отмена бронирования', 'place', this.uData.id);
            } else {
                this.$refs.message.modal.show();
            }
        },
        cancelBooking() {
            this.bookingModal.hide();
            var id = this.currentClient.id;
            this.changeStatus(id);
            this.getClients();
        },
        bModal(i) {
            this.bookingModal.show();
            this.currentClient = this.clientList[i];
        },
        async addBox() {
            if (this.zone !== -1) {
                this.element = {top: this.otstupTop, left: this.otstupLeft, offsetLeft: 0, bg: 'red'}; //offsetLeft используется для вычисления смещения при изменении размера окна
                this.positions.push(this.element);
                this.element = {};
                var club_id  = JSON.parse(this.$props.club).id;

                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                var urlencoded = new URLSearchParams();
                urlencoded.append("posx", "115");
                urlencoded.append("posy", "500");
                urlencoded.append("zone", this.zone + 1);
                urlencoded.append("club_id", club_id);
                urlencoded.append("id_comp", this.positions.length);

                var requestOptions = {
                    method  : 'POST',
                    headers : myHeaders,
                    body    : urlencoded,
                    redirect: 'follow'
                };

                var response = await fetch("api/saveNewPosition", requestOptions);
                if (response.ok) {
                    var data = {
                        "zone"   : this.zone + 1,
                        "club_id": club_id,
                        "id_comp": this.positions.length
                    }
                    createLog(JSON.stringify(data), 'Добавление ПК', 'place', this.uData.id)
                } else {
                    this.$refs.message.modal.show();
                }
            } else {
                this.$refs.sysMessage.text = 'Выберите зону';
                this.$refs.sysMessage.modal.show();
            }
        },
        // Проверка состояния окна Открытие смены
        async verifyOpenShift() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("user_id", JSON.parse(this.$props.userData).id);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/verifyopenshift", requestOptions);
            if (response.ok) {
                var result = await response.text();
                if (result === 'open') {
                    location.reload();
                }
            } else {
                this.$refs.message.modal.show();
            }
        },
        // Проверка состояния окна Закрытие смены
        async verifyCloseShift() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("user_id", JSON.parse(this.$props.userData).id);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = fetch("api/verifycloseshift", requestOptions);
            if (response.ok) {
                var result = await response.text();
                if (result === 'open') {
                    location.reload();
                }
            } else {
                this.$refs.message.modal.show();
            }
        },
        switchShift() {
            if (this.shiftStatusOpen) {
                this.shiftOpenClose = 'Закрыть смену';
                this.modalHeader    = "Открытие смены";
                this.modal.show();
                this.timerId = setInterval(this.verifyOpenShift, 15000);
                console.log('shiftopen');
            } else {
                this.shiftOpenClose = "Открыть смену";
                this.modalHeader    = "Закрытие смены";
                this.modal.show();
                this.timerId = setInterval(this.verifyCloseShift, 15000);
                console.log('shiftclose');
            }
            this.shiftStatusOpen = !this.shiftStatusOpen;
        },
        changeZone(i) {
            this.zones.forEach(function (item) {
                item.active = false;
            });
            this.zones[i].active = !this.zones[i].active;
            this.zone            = this.zones[i].num;

            this.positions.forEach(function (item) {
                item.mainborder = item.zone == this.zone;
            }.bind(this));
        },
        poweron() {
            var outData = {
                pc : 'poweron',
                mac: this.contextMenuData.mac,
                ip : this.contextMenuData.ip
            }
            var result  = JSON.stringify(outData);
            console.log(result);
            this.hideContextMenu();
        },
        poweroff() {
            var outData2 = {
                pc : 'poweroff',
                mac: this.contextMenuData.mac,
                ip : this.contextMenuData.ip
            }
            var result2  = JSON.stringify(outData2);
            console.log(result2);
            this.hideContextMenu();
        },
        reboot() {
            var outData3 = {
                pc : 'reboot',
                mac: this.contextMenuData.mac,
                ip : this.contextMenuData.ip
            }
            var result3  = JSON.stringify(outData3);
            console.log(result3);
            this.hideContextMenu();
        },
        sos() {
            var id = this.contextMenuData.id
            this.stopSOS(id);
            this.hideContextMenu();
        },
        sendMessageFromMenu() {
            this.hideContextMenu();
            this.messageIp   = this.contextMenuData.ip;
            this.messageText = '';
            this.messageModal0.show();
        },
        hideContextMenu() {
            this.contextMenuShow = false;
            this.contextMenuAdd  = false;
        },
        async stopSOS(id) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id", id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/map/stopsos", requestOptions);
            if (response.ok) {
                this.getMapPosition();
            } else {
                this.$refs.message.modal.show();
            }
        },
        sendMessage() {
            this.messageModal0.hide();
            var outData = {
                message: this.messageText,
                ip     : this.messageIp
            }
            var result  = JSON.stringify(outData);
            console.log(result);
        },
        move(e) {
            if (dragObject) {
                //Смещение объекта по сетке 10
                this.positions[globalIndex].left       = Math.round((e.pageX - offsetX - 101) / 10) * 10; // Чтобы перемещение влево-вправо было по сетке 10
                this.positions[globalIndex].offsetLeft = this.positions[globalIndex].left - this.otstupLeft;
                this.positions[globalIndex].top        = Math.round((e.pageY - offsetY - 99) / 10) * 10; // Чтобы перемещение вверх-вниз было по сетке 10
                //Ограничение смещения в пределах разрешенной зоны
                if (this.positions[globalIndex].left <= this.otstupLeft)
                    this.positions[globalIndex].left = this.otstupLeft;
                if (this.positions[globalIndex].top <= this.otstupTop)
                    this.positions[globalIndex].top = this.otstupTop;
                if (this.positions[globalIndex].left > this.widthout + this.otstupLeft - this.boxWidth)
                    this.positions[globalIndex].left = this.widthout + this.otstupLeft - this.boxWidth;
                if (this.positions[globalIndex].top > this.lowout - this.boxHeight)
                    this.positions[globalIndex].top = this.lowout - this.boxHeight;
            }
        },
        contextMenu(e, index) {
            this.contextMenuShow   = true;
            this.contextMenuTop    = e.pageY;
            this.contextMenuLeft   = e.pageX;
            this.contextMenuTopAdd = this.contextMenuTop;
            this.contextMenuUserId = this.positions[index].user_id;
            if (this.contextMenuUserId != null)
                this.getLogin(this.contextMenuUserId);
            if (this.positions[index].user_id != null) {
                this.contextMenuShowHeader = true;
                this.contextMenuHeight     = 175;
            } else {
                this.contextMenuShowHeader = false;
                this.contextMenuHeight     = 140;
            }
            this.contextMenuData.mac = this.mapTable[index].mac;
            this.contextMenuData.ip  = this.mapTable[index].ip;
            this.contextMenuData.id  = this.mapTable[index].id;
            this.login               = this.mapTable[index].login;
            this.$nextTick(() => {
                const context     = document.querySelector('#context');
                const bottomCoord = context.offsetTop + context.offsetHeight;
                if (bottomCoord > 870) {
                    this.contextMenuTop    = 870 - this.contextMenuHeight;
                    this.contextMenuTopAdd = 870 - this.contextMenuHeightAdd;
                }
            })
        },
        mdown(e, index) {
            if (this.permissionMove) {
                globalIndex = index;
                //Разрешить смещение
                dragObject  = true;
                //Получаем координаты мыши внутри смещаемого объекта
                offsetX     = e.offsetX;
                offsetY     = e.offsetY;
            }
        },
        async getLogin(id) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("user_id", id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/client/getlogin", requestOptions);
            if (response.ok) {
                var result = await response.json();
                this.login = result.login;
            } else {
                this.$refs.message.modal.show();
            }
        },
        payment() {
            var outData = {
                data      : {
                    "userid"  : this.contextMenuData.id,
                    "paytype" : this.pay,
                    "check"   : this.chek,
                    "comment" : this.comment,
                    "admin_id": this.uData.id
                },
                "prodlist": [{
                    "amount"  : this.summa,
                    "product" : "Пополнение счёта",
                    "quantity": 1
                }]
            };
            console.log(JSON.stringify(outData));
            this.messages = [];
        },
        contextMenuUserIdClick() {
            this.contextMenuAdd = !this.contextMenuAdd;
            this.$nextTick(() => {
                const munuAdd       = document.querySelector('#userIdHeaderMenu');
                const munuAddBottom = munuAdd.offsetTop + munuAdd.offsetHeight;
                if (munuAddBottom > 870) {
                    this.contextMenuTopAdd = 870 - this.contextMenuHeightAdd;
                }
            })
        },
        mmup(e) {
            dragObject = false;
            if (this.positions[globalIndex] !== undefined) {
                var left = this.positions[globalIndex].left;
                var top  = this.positions[globalIndex].top;

                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                var urlencoded = new URLSearchParams();
                urlencoded.append("comp", globalIndex + 1);
                urlencoded.append("posx", left);
                urlencoded.append("posy", top);
                urlencoded.append("club_id", JSON.parse(this.$props.userData).club_id);

                var requestOptions = {
                    method  : 'POST',
                    headers : myHeaders,
                    body    : urlencoded,
                    redirect: 'follow'
                };

                fetch("api/saveMapPosition", requestOptions)
                    .then(response => response.text())
                    .catch(error => console.log('error', error));
            }
        },
        async getClients() {
            var club_id   = JSON.parse(this.$props.club).id;
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/booking/all", requestOptions);
            if (response.ok) {
                this.clientList = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getSmena() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", JSON.parse(this.$props.userData).club_id);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response  = await fetch("api/getSmena", requestOptions);
            var result    = await response.json();
            this.nalic    = Number(result.finance[0].cash) + Number(result.finance[0].shop_cash);
            this.card     = Number(result.finance[0].nocash) + Number(result.finance[0].shop_nocash);
            this.goods    = Number(result.finance[0].shop_cash) + Number(result.finance[0].shop_nocash);
            this.services = Number(result.finance[0].cash) + Number(result.finance[0].nocash);
            this.time     = result.finance[0].time;
            var shift     = result.shift;
            if (shift === 'open') {
                this.shiftStatus     = 'Начало смены';
                this.shiftOpenClose  = 'Закрыть смену';
                this.shiftStatusOpen = false;
            } else {
                this.shiftStatus     = 'Смена закрыта';
                this.shiftOpenClose  = 'Открыть смену';
                this.shiftStatusOpen = true;
            }
        },
        async getTasks() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.uData.club_id);
            urlencoded.append("admin_id", this.uData.id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/tasks", requestOptions);
            if (response.ok) {
                this.tasks = await response.json();
                this.$nextTick(() => {
                    this.tooltipSetup();
                });
            } else {
                this.$refs.message.modal.show();
            }
        },
        async mapUserId() {
            var club_id   = JSON.parse(this.$props.club).id;
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/map/user-id", requestOptions);
            if (response.ok) {
                var result = await response.json();
                this.positions.forEach(function (item, index) {
                    item.user_id = result[index].user_id;
                    if (item.user_id != null && item.ping == 1) {
                        item.bg            = '#61babe';
                        item.userIdNotNull = true;
                    }
                }.bind(this));
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getMapPosition() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var club_id    = JSON.parse(this.$props.club).id;
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/getMapPosition", requestOptions);
            if (response.ok) {
                var result        = await response.json();
                this.mapTable     = result.map;
                var userIdNotNull = false;
                this.positions    = [];
                var bg            = '';
                result.map.forEach(function (item) {
                    if (item.user_id != null && item.ping == 1) {
                        bg            = '#61babe';
                        userIdNotNull = true;
                    }
                    if (item.ping == 0) {
                        bg            = '#363636';
                        userIdNotNull = true;
                    }
                    if (item.user_id == null && item.ping == 1) {
                        bg            = '#01B253';
                        userIdNotNull = true;
                    }
                    this.element = {
                        user_id      : item.user_id,
                        login        : item.login,
                        top          : item.pos_y,
                        left         : item.pos_x,
                        offsetLeft   : 0,      //offsetLeft используется для вычисления смещения при изменении размера окна
                        zone         : item.zone,
                        ping         : item.ping,
                        bg           : bg,
                        mainborder   : false,
                        userIdNotNull: userIdNotNull,
                        sos          : item.sos
                    };
                    this.positions.push(this.element);
                    this.element = {};
                }.bind(this));
                this.zones = result.zone;
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getNewTask() {
            const urlencoded = new URLSearchParams();
            urlencoded.append("club_id", JSON.parse(this.$props.club).id);
            urlencoded.append("user_id", JSON.parse(this.$props.userData).id);

            const requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            const response = await fetch("api/task/get-new", requestOptions);
            if (response.ok) {
                this.count = await response.text();
                if (this.count > 0) {
                    this.toast.show();
                    setTimeout(function () {
                        this.taskUnvisible();
                    }.bind(this), 5000);
                }
            }
        },
        async taskUnvisible() {
            const urlencoded = new URLSearchParams();
            urlencoded.append("club_id", JSON.parse(this.$props.club).id);
            urlencoded.append("user_id", JSON.parse(this.$props.userData).id);

            const requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            const response = await fetch("api/task/unvisible", requestOptions);
            if (!response.ok) {
                this.$refs.message.modal.show();
            }

        }
    },
    mounted() {
        this.toastLiveExample = document.getElementById('liveToast');
        this.toast            = new bootstrap.Toast(this.toastLiveExample);

        var shiftModal = document.getElementById('shiftModal')
        this.modal     = bootstrap.Modal.getOrCreateInstance(shiftModal);

        var bookingModal  = document.getElementById('bookingModal')
        this.bookingModal = bootstrap.Modal.getOrCreateInstance(bookingModal);

        var addZoneModal  = document.getElementById('addZoneModal')
        this.addZoneModal = bootstrap.Modal.getOrCreateInstance(addZoneModal);

        var messageModal0  = document.getElementById('messageModal0')
        this.messageModal0 = bootstrap.Modal.getOrCreateInstance(messageModal0);

        var topBalanceModal  = document.getElementById('topBalanceModal')
        this.topBalanceModal = bootstrap.Modal.getOrCreateInstance(topBalanceModal);

        var editTaskModal  = document.getElementById('editTaskModal')
        this.editTaskModal = bootstrap.Modal.getOrCreateInstance(editTaskModal);

        let i = 1;
        for (i = 1; i <= 7; i++) {
            this.deadLineDay.push(i);
        }
        i = 1;
        for (i = 1; i <= 24; i++) {
            this.deadLineHours.push(i);
        }

        shiftModal.addEventListener('hidden.bs.modal', event => {
            clearTimeout(this.timerId);
        });

        setInterval(function () {
            this.getMapPosition();
        }.bind(this), 15000);

        setInterval(function () {
            this.getNewTask();
        }.bind(this), 15000);


        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                this.contextMenuShow = false;
                this.contextMenuAdd  = false;
            }
        }.bind(this));

        this.club = JSON.parse(this.$props.club);
        this.getDiagramData();
        var userData = JSON.parse(this.$props.userData);
        this.uData   = userData.user;

        this.height    = window.innerHeight;
        this.width     = window.innerWidth;
        this.widthout  = document.querySelector('.outbox').offsetWidth;
        this.otstupTop = document.querySelector('.outbox').offsetTop;
        this.lowout    = this.otstupTop + document.querySelector('.outbox').clientHeight; //Низ окна outbox

        this.getMapPosition();
        setInterval(this.mapUserId, 60000);

        this.getAllBookingsPerDay();
        this.getSmena();
        this.getClients();
        this.getTasks();
        this.getUsers();
        this.getPermissions();
        console.log(this.$props.club);
        console.log(this.$props.userData);

        this.$nextTick(() => {
            document.addEventListener('click', function (event) {
                if (event.target.className != 'userIdHeader' && event.target.className != 'userIdHeaderMenu') {
                    this.contextMenuShow = false;
                    this.contextMenuAdd  = false;
                }
            }.bind(this));
        });
    }
}
</script>

<style lang="scss" scoped>

#line-chart {
    width  : 100%;
    height : 400px;

}

.block {
    display        : flex;
    flex-direction : column;
    align-items    : flex-start;
    margin-top     : 20px;
}

.input {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 6px;
    color         : var(--standart-gray);
    border        : none;
    width         : 465px;
    border-radius : 8px;
}

#liveToast {
    background : var(--dark-blue-bg-color);
    color      : var(--standart-gray);
}

.toast-header {
    background : var(--light-blue-bg-color);
    color      : var(--standart-gray);

    .btn-close {
        color : var(--standart-gray);
    }
}

.timebtn {
    width : 73px;
}

.check-1 {
    & + label {
        display     : inline-flex;
        align-items : center;
        user-select : none;

        &::after {
            content             : '';
            display             : inline-block;
            width               : 1em;
            height              : 1em;
            flex-shrink         : 0;
            flex-grow           : 0;
            border              : 1px solid #adb5bd;
            border-radius       : 0.25em;
            margin-right        : 0.5em;
            background-repeat   : no-repeat;
            background-position : center center;
            background-size     : 50% 50%;
            left                : 186px;
            position            : absolute;
        }
    }

    &:checked {
        & + label {
            &::after {
                border-color     : #0b76ef;
                background-color : #0b76ef;
                background-image : url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
            }
        }
    }
}

.label-1 {
    font-size : 15px;
    width     : 500px;
}

.check-2 {
    & + label {
        display     : inline-flex;
        align-items : center;
        user-select : none;

        &::after {
            content             : '';
            display             : inline-block;
            width               : 1em;
            height              : 1em;
            flex-shrink         : 0;
            flex-grow           : 0;
            border              : 1px solid #adb5bd;
            border-radius       : 0.25em;
            margin-right        : 0.5em;
            background-repeat   : no-repeat;
            background-position : center center;
            background-size     : 50% 50%;
            left                : 416px;
            position            : absolute;
        }
    }

    &:checked {
        & + label {
            &::after {
                border-color     : #0b76ef;
                background-color : #0b76ef;
                background-image : url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
            }
        }
    }
}

.div_1 {
    height         : 74px;
    display        : flex;
    flex-direction : column;
}

.div_2 {
    height  : 200px;
    display : flex;
}

.div_3 {
    width   : 49.5%;
    height  : 100%;
    display : inline-block;
    padding : 12px;
}

.input_1 {
    background : #172d39;
    border     : none;
    padding    : 5px;
    margin-top : 5px;
    color      : white;
}

.div_4 {
    height                     : 35px;
    background                 : #172d39;
    padding                    : 5px 15px 5px 15px;
    border-bottom-left-radius  : 27px;
    border-top-right-radius    : 27px;
    border-top-left-radius     : 5px;
    border-bottom-right-radius : 5px;
    margin-top                 : 10px;
}

.userIdHeader {
    border-bottom   : 2px groove black;
    justify-content : space-between;
    padding-right   : 15px;
}

#userIdHeaderMenu {
    background    : var(--context-menu);
    box-shadow    : 0 1px 10px 0 rgba(0, 0, 0, 0.15);
    color         : white;
    position      : absolute;
    border-radius : 10px;
    overflow      : hidden;
    width         : 15rem;

    div {
        height       : 35px;
        width        : 100%;
        cursor       : pointer;
        display      : flex;
        align-items  : center;
        padding-left : 10px;

        &:hover {
            background : var(--light-blue-bg-color);
            color      : var(--standart-gray);
        }
    }
}

.context-menu {
    background    : var(--context-menu);
    box-shadow    : 0 1px 10px 0 rgba(0, 0, 0, 0.15);
    color         : white;
    position      : absolute;
    border-radius : 10px;
    overflow      : hidden;
    width         : 200px;

    div {
        height       : 35px;
        width        : 100%;
        cursor       : pointer;
        display      : flex;
        align-items  : center;
        padding-left : 10px;

        &:hover {
            background : var(--light-blue-bg-color);
            color      : var(--standart-gray);
        }
    }
}

ul {
    li {
        list-style-type : none;
    }
}

.zoneBorder {
    border : 2px solid #dbcf4b;
}

.sos {
    width         : 5px;
    height        : 5px;
    background    : red;
    position      : absolute;
    top           : 15px;
    left          : 2px;
    border-radius : 5px;
    animation     : blink 1s infinite;
}

@keyframes blink {
    50% {
        opacity : 0;
    }
}

.chart_1 {
    margin-top    : 20px;
    overflow      : hidden;
    border-radius : 10px;
}

.fullscreen {
    width    : 1791px;
    left     : -179px;
    position : relative;
}

#messageModal0 {
    textarea {
        width         : 100%;
        height        : 150px;
        background    : var(--dark-blue-bg-color);
        border        : none;
        border-radius : 7px;
        padding       : 7px;
        color         : var(--standart-gray);
    }

    .modal-body {
        padding : 15px;
    }
}

.center-plus-right {
    width           : 1820px;
    height          : 815px;
    display         : flex;
    justify-content : space-around;
    align-items     : flex-end;
    position        : relative;
}

.graphic {
    height        : 272px;
    width         : 952px;
    background    : var(--light-blue-bg-color);
    border-radius : 20px;
    overflow      : hidden;
}

.active-bron {
    width          : 465px;
    background     : var(--light-blue-bg-color);
    border-radius  : 20px;
    display        : flex;
    align-items    : center;
    flex-direction : column;
}

.shift-close {
    height        : 84px;
    background    : var(--light-blue-bg-color);
    border-radius : 20px;
}

.cash {
    height         : 318px;
    //background: var(--light-blue-bg-color);
    background     : #183f52;
    border-radius  : 20px;
    margin-top     : 20px;
    display        : flex;
    flex-direction : column;
    align-items    : center;
}

.tasks {
    height        : 374px;
    background    : var(--light-blue-bg-color);
    border-radius : 20px;
    margin-top    : 20px;
}

.task-list {
    height       : 297px;
    width        : 250px;
    margin-top   : 30px;
    margin-left  : auto;
    margin-right : auto;
    overflow     : auto;
}

.manager {
    margin-top    : 20px;
    background    : var(--light-blue-bg-color);
    border-radius : 20px;
}

.all-buttons {
    height          : 42px;
    margin-top      : 50px;
    display         : flex;
    align-items     : center;
    justify-content : space-between;
}

.panel-manager {
    color        : var(--standart-color);
    margin-left  : 20px;
    margin-right : 20px;
}

.nal-card {
    margin-top : 20px;
}

.task {
    height          : 42px;
    background      : var(--standart-black);
    border-radius   : 10px;
    display         : flex;
    justify-content : space-between;
    align-items     : center;
    padding-left    : 5px;
    margin-top      : 9px;
    cursor          : pointer;
}

.intask {
    width           : 98px;
    height          : 32px;
    border-radius   : 10px;
    display         : flex;
    justify-content : center;
    align-items     : center;
}

.tasks-text {
    color : var(--standart-gray);
}

.task-1 {
    display     : flex;
    align-items : center;
}

.active-bron2 {
    width           : 210px;
    height          : 64px;
    background      : var(--standart-black);
    border-radius   : 10px;
    display         : flex;
    align-items     : center;
    justify-content : space-between;
    margin-top      : 10px;
    cursor          : pointer;
}

.active-bron2-right {
    width           : 101px;
    height          : 44px;
    border-style    : dotted;
    margin-right    : 14px;
    display         : flex;
    flex-direction  : column;
    justify-content : center;
}

.active-bron2-text {
    color     : var(--light-green);
    font-size : 13px;
}

.tasks-text-2 {
    font-size : 12px;
    color     : var(--standart-gray);
}

.time {
    color     : var(--standart-color);
    font-size : 18px;
}

.active-bron-buttons {
    width           : 442px;
    height          : 220px;
    margin-top      : 4px;
    display         : flex;
    flex-wrap       : wrap;
    justify-content : space-between;
    overflow        : auto;
    padding-right   : 5px;
    align-content   : flex-start;
}

.waiting {
    display : block;
    margin  : 23px;
}

.input_zone {
    margin        : 15px;
    width         : 90%;
    background    : var(--dark-blue-bg-color);
    border        : none;
    border-radius : 7px;
    padding       : 7px;
    color         : gray;
}

.main_modal {
    width          : 800px;
    height         : 314px;
    background     : var(--light-blue-bg-color);
    display        : flex;
    flex-direction : column;
    align-items    : center;
}

.info_modal {
    width         : 760px;
    background    : var(--dark-blue-bg-color);
    border-radius : 20px;
}

.contact_modal {
    width         : 760px;
    height        : 60px;
    background    : var(--dark-blue-bg-color);
    border-radius : 20px;
    display       : flex;
    padding-top   : 4px;
    margin-top    : 10px;
}

.user_info_modal {
    color       : var(--standart-gray);
    margin-top  : 10px;
    font-size   : 13px;
    width       : 90%;
    margin-left : 10px;

    td {
        width : 50%;
    }
}

.value_modal {
    color : var(--light-green);
}

.shiftModal {
    background : var(--dark-green-b);
    color      : var(--standart-gray);
}

.close-cross {
    width    : 28px;
    height   : 28px;
    position : absolute;
    left     : 258px;
    z-index  : 100;
}

.box {
    border-radius : 10px;
    position      : absolute;
    text-align    : center;
    font-size     : 19px;
    color         : white;
    user-select   : none;
    padding-top   : 5px;

    &:hover {
        cursor : move;
    }
}

.button-shift-close {
    width           : 126px;
    height          : 44px;
    display         : flex;
    justify-content : center;
    align-items     : center;
    cursor          : pointer;
}
</style>
