<template>
    <div class="center-plus-right">
        <div style="width: 1438px;height: 965px;">
            <div style="width: 1438px;height: 272px;display: flex;justify-content: space-between;">
                <div class="graphic"></div>
                <div class="active-bron">
                    <div style="width: 430px;margin-top: 10px;color: var(--standart-gray);"><i class="fas fa-book-open"></i><span style="font-size: 13px;margin-left: 11px;">Активные бронирования ПК</span></div>

                    <div class="active-bron-buttons">
                        <div class="active-bron2" v-for="(c, i) in clientList">
                            <div class="active-bron2" @click="bModal(i)">
                                <div class="active-bron2-left"><span class="time">{{ c.time_start }}</span></div>
                                <div class="active-bron2-right"><span class="active-bron2-text">{{ c.login }}</span><span class="tasks-text-2">{{ c.map_comp_id }} компьютер</span></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div @mousemove="move" @mouseup="mmup">
                <div class="all-buttons">
                    <div style="display: flex;align-items: center;"><i class="fab fa-delicious fs-2" style="color: var(--standart-color);"></i><span class="panel-manager">Панель управления</span>
                        <div class="buttons-dark"><span style="color: var(--standart-color);">Общая карта</span></div>
                        <div v-for="(zone, index) in zones" :class="[{'button-active': zones[index].active, 'buttons': true}]" @click="changeZone(index)"><span>{{ zone.name }}</span></div>
                    </div>
                    <div style="display: flex;align-items: center;">
                        <div class="buttons"  @click="addBox" style="width: 57px;height: 34px;"><i class="fas fa-plus fs-5"></i></div>
                        <div class="buttons-dark" style="width: 57px;height: 34px;"><i class="fas fa-lock fs-5"></i></div>
                        <div class="buttons-dark" style="width: 185px;height: 42px;"><span>Клиентская карта</span></div>
                    </div>
                </div>
                <div class="manager outbox">
                    <div v-for="(position, index) in positions" class="box" @mousedown="mdown($event, index)"
                         :style="{top: position.top + 'px', left: position.left + 'px', width: boxWidth + 'px', height: boxHeight + 'px', background: boxColor}">
                        {{ index + 1 }}
                        <div class="inbox" :style="{'background-color': position.bg}"></div>
                    </div>
                </div>
            </div>
        </div>
        <div style="width: 323px;height: 965px;">
            <div class="shift-close" style="display: flex;align-items: center;justify-content: center;">
                <div style="width: 149px;height: 44px;display: flex;justify-content: center;align-items: center;"><i class="far fa-clock" style="color: var(--standart-gray);font-size: 21px;"></i>
                    <div style="width: 130px;height: 40px;display: flex;flex-direction: column;"><span style="color: var(--standart-gray);text-align: center;font-size: 15px;font-weight: bold;">{{ shiftStatus }}</span><span style="color: var(--standart-gray);text-align: center;font-size: 15px;">{{ time }}</span></div>
                </div>
                <div class="button-shift-close" @click="switchShift"><span style="font-size: 15px;font-weight: bold;">{{ shiftOpenClose }}</span></div>
            </div>
            <div class="cash">
                <div class="nal-card"><span style="color: var(--standart-gray);">Наличные/карта</span>
                    <div style="width: 250px;height: 32px;background: #122834;border-radius: 10px;margin-top: 5px;display: flex;align-items: center;justify-content: space-between;padding-right: 15px;">
                        <div style="width: 179px;height: 32px;background: var(--standart-green);border-radius: 10px;display: flex;justify-content: flex-start;align-items: center;padding-left: 15px;"><span>{{ nalic }}</span></div><span style="color: var(--standart-gray);">{{ card }}</span>
                    </div>
                </div>
                <div class="nal-card"><span style="color: var(--standart-gray);">Товары/услуги</span>
                    <div style="width: 250px;height: 32px;background: #122834;border-radius: 10px;margin-top: 5px;display: flex;align-items: center;justify-content: space-between;padding-right: 15px;">
                        <div style="width: 179px;height: 32px;background: var(--standart-green);border-radius: 10px;display: flex;justify-content: flex-start;align-items: center;padding-left: 15px;"><span>{{ goods }}</span></div><span style="color: var(--standart-gray);">{{ services }}</span>
                    </div>
                </div>
            </div>
            <div class="tasks"><span style="color: var(--standart-gray);display: block;position: relative;top: 20px;left: 40px;width: 143px;">Список задач</span>
                <div class="task-list">
                    <div class="task">
                        <div class="task-1">
                            <div class="intask"><span style="color: var(--standart-gray);font-size: 12px;">18.02.22 14:00</span></div><span class="tasks-text" style="font-size: 12px;margin-left: 7px;">Провести уборку</span>
                        </div><i class="fas fa-caret-right" style="color: var(--standart-gray);margin-right: 10px;"></i>
                    </div>
                    <div class="task">
                        <div class="task-1">
                            <div class="intask"><span style="color: var(--standart-gray);font-size: 12px;">18.02.22 14:00</span></div><span class="tasks-text" style="font-size: 12px;margin-left: 7px;">Провести уборку</span>
                        </div><i class="fas fa-caret-right" style="color: var(--standart-gray);margin-right: 10px;"></i>
                    </div>
                    <div class="task">
                        <div class="task-1">
                            <div class="intask"><span style="color: var(--standart-gray);font-size: 12px;">18.02.22 14:00</span></div><span class="tasks-text" style="font-size: 12px;margin-left: 7px;">Провести уборку</span>
                        </div><i class="fas fa-caret-right" style="color: var(--standart-gray);margin-right: 10px;"></i>
                    </div>
                    <div class="task">
                        <div class="task-1">
                            <div class="intask"><span style="color: var(--standart-gray);font-size: 12px;">18.02.22 14:00</span></div><span class="tasks-text" style="font-size: 12px;margin-left: 7px;">Провести уборку</span>
                        </div><i class="fas fa-caret-right" style="color: var(--standart-gray);margin-right: 10px;"></i>
                    </div>
                    <div class="task">
                        <div class="task-1">
                            <div class="intask"><span style="color: var(--standart-gray);font-size: 12px;">18.02.22 14:00</span></div><span class="tasks-text" style="font-size: 12px;margin-left: 7px;">Провести уборку</span>
                        </div><i class="fas fa-caret-right" style="color: var(--standart-gray);margin-right: 10px;"></i>
                    </div>
                    <div class="task">
                        <div class="task-1">
                            <div class="intask"><span style="color: var(--standart-gray);font-size: 12px;">18.02.22 14:00</span></div><span class="tasks-text" style="font-size: 12px;margin-left: 7px;">Провести уборку</span>
                        </div><i class="fas fa-caret-right" style="color: var(--standart-gray);margin-right: 10px;"></i>
                    </div>
                    <div class="task">
                        <div class="task-1">
                            <div class="intask"><span style="color: var(--standart-gray);font-size: 12px;">18.02.22 14:00</span></div><span class="tasks-text" style="font-size: 12px;margin-left: 7px;">Провести уборку</span>
                        </div><i class="fas fa-caret-right" style="color: var(--standart-gray);margin-right: 10px;"></i>
                    </div>
                    <div class="task">
                        <div class="task-1">
                            <div class="intask"><span style="color: var(--standart-gray);font-size: 12px;">18.02.22 14:00</span></div><span class="tasks-text" style="font-size: 12px;margin-left: 7px;">Провести уборку</span>
                        </div><i class="fas fa-caret-right" style="color: var(--standart-gray);margin-right: 10px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="shiftModal" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content shiftModal">
                <div class="modal-header">
                    <div class="shiftModal close-cross"></div>
                    <h5 class="modal-title" id="shiftModalLabel">{{ modalHeader }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <span>Ждите. Операция выполняется...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Информация о бронировании</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <div class="main_modal">
                        <div class="info_modal" style="margin-top: 26px;">
                            <div class="table-responsive">
                                <table class="table table-borderless user_info_modal">
                                    <tbody>
                                    <tr>
                                        <td><span class="name_modal">Пользователь: </span><span class="value_modal">{{ currentClient.login }}</span></td>
                                        <td><span class="name_modal">Компьютер: </span><span class="value_modal">{{ currentClient.zone }} {{ currentClient.map_comp_id }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Дата: </span><span class="value_modal">{{ currentClient.date }}</span></td>
                                        <td><span class="name_modal">Время: </span><span class="value_modal">{{ currentClient.time_start }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Тариф: </span><span class="value_modal">{{ currentClient.tariff }}</span></td>
                                        <td><span class="name_modal">Источник: </span><span class="value_modal">booking.refresh-software.ru/id3456789</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Оплата: </span><span class="value_modal">Произведена</span></td>
                                        <td><span class="name_modal">Метод оплаты: </span><span class="value_modal">Банковская карта (онлайн)</span></td>
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
                                        <td><span class="name_modal">Номер телефона: </span><span class="value_modal">{{ currentClient.phone }}</span></td>
                                        <td><span class="name_modal">E-mail: </span><span class="value_modal">{{ currentClient.email }} {{ currentClient.map_comp_id }}</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="cancelBooking">Отмена бронирования</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
var dragObject = false; //Смещение объекта запрещено
var offsetX = 0; //Смещение мышки внутри перемещаемого элемента по X
var offsetY = 0; //Смещение мышки внутри перемещаемого элемента по Y
var globalIndex = 0;
export default {
    props: ['name', 'club', 'userData'],
    data() {
        return {
            height: 0, //Высота окна браузера
            width: 0, //Ширина окна браузера
            widthout: 0, //Ширина окна outbox
            lowout: 0, //Низ окна outbox
            otstupLeft: 114, //Отступ слева окна outbox
            otstupTop: 0, //Отступ сверху окна outbox
            boxHeight: 35, //Высота подвижного кубика
            boxWidth: 35, //Ширина подвижного кубика
            boxColor: '#6FC8CC',
            positions: [],
            element: {},
            //---------------------
            zones: [],
            active: false,
            zone: -1,
            nalic: 0,
            card: 0,
            goods: 0,
            services: 0,
            time: null,
            shiftStatus: "Начало смены",
            shiftOpenClose: 'Закрыть смену',
            shiftStatusOpen: true, //Смена открыта - значит true
            modal: null,
            bookingModal: null,
            timerId: null,
            modalHeader: "Открытие смены",
            //------------------------
            clientList: [],
            currentClient: {}
        }
    },
    methods: {
        async changeStatus(id) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id", id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            fetch("api/booking/cancel", requestOptions);
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
        addBox() {
            if (this.zone !== -1) {
                this.element = {top:top, left: this.otstupLeft, offsetLeft: 0}; //offsetLeft используется для вычисления смещения при изменении размера окна
                this.positions.push(this.element);
                this.element = {};

                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                var urlencoded = new URLSearchParams();
                urlencoded.append("posx", "115");
                urlencoded.append("posy", "500");
                urlencoded.append("zone", this.zone + 1);
                urlencoded.append("id_comp", this.positions.length);

                var requestOptions = {
                    method: 'POST',
                    headers: myHeaders,
                    body: urlencoded,
                    redirect: 'follow'
                };

                fetch("api/saveNewPosition", requestOptions);
            }
            else {
                alert ('Выберите зону');
            }
        },
        closeModal(){
            this.modal.hide();
            clearTimeout(this.timerId);
        },
        // Проверка состояния окна Открытие смены
        verifyOpenShift() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("user_id", JSON.parse(this.$props.userData).id);

            var requestOptions = {
                method: 'POST',
                body: urlencoded,
                redirect: 'follow'
            };

            fetch("api/verifyopenshift", requestOptions)
                .then(response => response.text())
                .then(result => {
                    if (result === 'open'){
                        location.reload();
                    }
                })
                .catch(error => console.log('error', error));
        },
        // Проверка состояния окна Закрытие смены
        verifyCloseShift() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("user_id", JSON.parse(this.$props.userData).id);

            var requestOptions = {
                method: 'POST',
                body: urlencoded,
                redirect: 'follow'
            };

            fetch("api/verifycloseshift", requestOptions)
                .then(response => response.text())
                .then(result => {
                    if (result === 'open'){
                        location.reload();
                    }
                })
                .catch(error => console.log('error', error));
        },
        switchShift() {
            if (this.shiftStatusOpen) {
                this.shiftOpenClose = 'Закрыть смену';
                this.modalHeader = "Открытие смены";
                this.modal.show();
                this.timerId = setInterval(this.verifyOpenShift,5000);
                console.log('shiftopen');
            }
            else {
                this.shiftOpenClose = "Открыть смену";
                this.modalHeader = "Закрытие смены";
                this.modal.show();
                this.timerId = setInterval(this.verifyCloseShift,5000);
                console.log('shiftclose');
            }
            this.shiftStatusOpen = !this.shiftStatusOpen;
        },
        changeZone(i) {
            this.zones.forEach(function (item){
                item.active = false;
            });
            this.zones[i].active = !this.zones[i].active;
            this.zone = i;
        },
        move(e) {
            if (dragObject) {
                //Смещение объекта по сетке 10
                this.positions[globalIndex].left = Math.round((e.pageX - offsetX) / 10) * 10; // Чтобы перемещение влево-вправо было по сетке 10
                this.positions[globalIndex].offsetLeft = this.positions[globalIndex].left - this.otstupLeft;
                this.positions[globalIndex].top = Math.round((e.pageY - offsetY)/10) * 10; // Чтобы перемещение вверх-вниз было по сетке 10
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
        mdown(e, index) {
                globalIndex = index;
                //Разрешить смещение
                dragObject = true;
                //Получаем координаты мыши внутри смещаемого объекта
                offsetX = e.offsetX;
                offsetY = e.offsetY;
        },
        mmup(e) {
            dragObject = false;
            if (this.positions[globalIndex] !== undefined){
                var left = this.positions[globalIndex].left;
                var top = this.positions[globalIndex].top;

                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                var urlencoded = new URLSearchParams();
                urlencoded.append("comp", globalIndex + 1);
                urlencoded.append("posx", left);
                urlencoded.append("posy", top);
                urlencoded.append("club_id", JSON.parse(this.$props.userData).club_id);

                var requestOptions = {
                    method: 'POST',
                    headers: myHeaders,
                    body: urlencoded,
                    redirect: 'follow'
                };

                fetch("api/saveMapPosition", requestOptions)
                    .then(response => response.text())
                    .catch(error => console.log('error', error));
            }
        },
        async getClients() {
            var club_id = JSON.parse(this.$props.club).id;
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", club_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/booking/all", requestOptions);
            this.clientList = await response.json();
        },
        async getSmena() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", JSON.parse(this.$props.userData).club_id);

            var requestOptions = {
                method: 'POST',
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/getSmena", requestOptions);
            var result = await response.json();
            this.nalic = Number(result.finance[0].cash) + Number(result.finance[0].shop_cash);
            this.card = Number(result.finance[0].nocash) + Number(result.finance[0].shop_nocash);
            this.goods = Number(result.finance[0].shop_cash) + Number(result.finance[0].shop_nocash);
            this.services = Number(result.finance[0].cash) + Number(result.finance[0].nocash);
            this.time = result.finance[0].time;
            var shift = result.shift;
            if (shift === 'open'){
                this.shiftStatus = 'Начало смены';
                this.shiftOpenClose = 'Закрыть смену';
                this.shiftStatusOpen = false;
            }
            else {
                this.shiftStatus = 'Смена закрыта';
                this.shiftOpenClose = 'Открыть смену';
                this.shiftStatusOpen = true;
            }
        },
    },
    created()  {
        window.addEventListener("resize", this.resizeHandler);
    },

    destroyed()  {
        window.removeEventListener("resize", this.resizeHandler);
    },
    mounted()  {
        var shiftModal = document.getElementById('shiftModal')
        this.modal = bootstrap.Modal.getOrCreateInstance(shiftModal);

        var bookingModal = document.getElementById('bookingModal')
        this.bookingModal = bootstrap.Modal.getOrCreateInstance(bookingModal);

        shiftModal.addEventListener('hidden.bs.modal', event => {
            clearTimeout(this.timerId);
        })

        this.height =  window.innerHeight;
        this.width =  window.innerWidth;
        this.widthout = document.querySelector('.outbox').offsetWidth;
        this.otstupTop = document.querySelector('.outbox').offsetTop;
        this.lowout = this.otstupTop + document.querySelector('.outbox').clientHeight; //Низ окна outbox

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

        var club_id = JSON.parse(this.$props.club).id;
        var urlencoded = new URLSearchParams();
        urlencoded.append("club_id", club_id);

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: urlencoded,
            redirect: 'follow'
        };

        fetch("api/getMapPosition", requestOptions)
            .then(response => response.json())
            .then(result => {
                result.map.forEach(function (item, index){
                    var bg = item.ping === 0 ? '#FE3434' : '#01B253';
                    this.element = {top: item.pos_y, left: item.pos_x, offsetLeft: 0, zone: item.zone, ping: item.ping, bg: bg}; //offsetLeft используется для вычисления смещения при изменении размера окна
                    this.positions.push(this.element);
                    this.element = {};
                }.bind(this));
                this.zones = result.zone;
                /*result.mapZone.forEach(function (item){
                    item.active = false;
                    this.zones.push(item);
                }.bind(this));*/
            })
            .catch(error => console.log('error', error));
        this.getSmena();
        this.getClients();
        console.log(this.$props.club);
        console.log(this.$props.userData);
    }
}
</script>

<style scoped>
.modal-footer {
    justify-content: flex-start;
}
.main_modal {
    width: 800px;
    height: 314px;
    background: var(--light-blue-bg-color);
    display: flex;
    flex-direction: column;
    align-items: center;
}
.modal-body {
    padding: 0;
}
.modal-content {
    background: var(--light-blue-bg-color);
    color: var(--standart-gray);
}
.info_modal {
    width: 760px;
    background: var(--dark-blue-bg-color);
    border-radius: 20px;
}

.contact_modal {
    width: 760px;
    height: 60px;
    background: var(--dark-blue-bg-color);
    border-radius: 20px;
    display: flex;
    padding-top: 4px;
    margin-top: 10px;
}

.user_info_modal {
    color: var(--standart-gray);
    margin-top: 10px;
    font-size: 13px;
    width: 90%;
    margin-left: 10px;
}

.user_info_modal td {
    width: 50%;
}

.value_modal {
    color: var(--light-green);
}
.inbox {
    width: 5px;
    height: 5px;
    border-radius: 3px;
    position: relative;
    left: 24px;
    top: -3px;
}
.shiftModal {
    background: var(--dark-green-b);
    color: var(--standart-gray);
}
.close-cross {
    width: 28px;
    height: 28px;
    position: absolute;
    left: 258px;
    z-index: 100;
}
.box {
    border-radius: 10px;
    border: 1px solid lightslategray;
    position: absolute;
    text-align: center;
    font-size: 19px;
    color: white;
    font-weight: bold;
    user-select: none;
    padding-top: 5px;
}
.box:hover {
    cursor: move;
}
.button-shift-close {
    width: 126px;
    height: 44px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}
</style>
