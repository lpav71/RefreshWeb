<template>
    <div class="center-plus-right">
        <div style="width: 1438px;height: 965px;">
            <div style="width: 1438px;height: 272px;display: flex;justify-content: space-between;">
                <div class="graphic"></div>
                <div class="active-bron">
                    <div style="width: 430px;margin-top: 10px;color: var(--standart-gray);"><i class="fas fa-book-open"></i><span style="font-size: 13px;margin-left: 11px;">Активные бронирования ПК</span></div>
                    <div class="active-bron-buttons">
                        <div class="active-bron2">
                            <div class="active-bron2-left"><span class="time">16:50</span></div>
                            <div class="active-bron2-right"><span class="active-bron2-text">Darvin</span><span class="tasks-text-2">28 компьютер</span></div>
                        </div>
                        <div class="active-bron2">
                            <div class="active-bron2-left"><span class="time">16:50</span></div>
                            <div class="active-bron2-right"><span class="active-bron2-text">Darvin</span><span class="tasks-text-2">28 компьютер</span></div>
                        </div>
                        <div class="active-bron2">
                            <div class="active-bron2-left"><span class="time">16:50</span></div>
                            <div class="active-bron2-right"><span class="active-bron2-text">Darvin</span><span class="tasks-text-2">28 компьютер</span></div>
                        </div>
                        <div class="active-bron2">
                            <div class="active-bron2-left"><span class="time">16:50</span></div>
                            <div class="active-bron2-right"><span class="active-bron2-text">Darvin</span><span class="tasks-text-2">28 компьютер</span></div>
                        </div>
                        <div class="active-bron2">
                            <div class="active-bron2-left"><span class="time">16:50</span></div>
                            <div class="active-bron2-right"><span class="active-bron2-text">Darvin</span><span class="tasks-text-2">28 компьютер</span></div>
                        </div>
                        <div class="active-bron2">
                            <div class="active-bron2-left"><span class="time">16:50</span></div>
                            <div class="active-bron2-right"><span class="active-bron2-text">Darvin</span><span class="tasks-text-2">28 компьютер</span></div>
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
                    <div v-for="(position, index) in positions" class="box" @mousedown="mdown($event, index)" :style="{top: position.top + 'px', left: position.left + 'px', width: boxWidth + 'px', height: boxHeight + 'px', background: boxColor}">{{index +1}}</div>
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
                    <h5 class="modal-title" id="shiftModalLabel">Открытие смены</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <span>Ждите. Операция выполняется...</span>
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
    props: ['name', 'club', 'user-data'],
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
            timerId: null
        }
    },
    methods: {
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
        verifyShift() {

            var requestOptions = {
                method: 'POST',
                redirect: 'follow'
            };

            fetch("api/verifyShift", requestOptions)
                .then(response => response.text())
                .then(result => {
                    if (result === 'open'){
                        this.modal.hide();
                        clearTimeout(this.timerId);
                    }
                })
                .catch(error => console.log('error', error));
        },
        switchShift() {
            if (this.shiftStatusOpen) {
                this.shiftOpenClose = 'Закрыть смену';
                this.modal.show();
                this.timerId = setInterval(this.verifyShift,500);
                console.log('shiftopen');
            }
            else {
                this.shiftOpenClose = "Открыть смену";
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
        async getSmena() {
            var urlencoded = new URLSearchParams();

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
                    this.element = {top: item.pos_y, left: item.pos_x, offsetLeft: 0, zone: item.zone}; //offsetLeft используется для вычисления смещения при изменении размера окна
                    this.positions.push(this.element);
                    this.element = {};
                }.bind(this));
                result.mapZone.forEach(function (item){
                    item.active = false;
                    this.zones.push(item);
                }.bind(this));
            })
            .catch(error => console.log('error', error));
        this.getSmena();
        console.log(this.$props.club);
        console.log(this.$props.userData);
    }
}
</script>

<style scoped>
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
