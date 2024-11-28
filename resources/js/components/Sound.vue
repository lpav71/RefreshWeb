<template>
    <div class="home">
        <div class="header">
            <div class="left">
                <div class="top"><img alt="" src="img/4.svg"/><span style="margin-left: 14px;">Настройка звука</span></div>
            </div>
        </div>
        <div class="bottom row">
            <div class="col-md-3">
                <div class="rw">
                    <label class="file_input" for="message">Сообщения</label>
                    <input id="message" ref="fileInput1" type="file" @change="onFileChange(1)">
                </div>
                <div class="rw">
                    <label class="file_input" for="notification">Уведомления</label>
                    <input id="notification" ref="fileInput2" type="file" @change="onFileChange(2)">
                </div>
                <div class="rw">
                    <label class="file_input" for="booking">Бронирование</label>
                    <input id="booking" ref="fileInput3" type="file" @change="onFileChange(3)">
                </div>
                <button class="btn btn-success" style="width: 100px" type="button" @click="uploadFiles">Сохранить</button>
            </div>
            <div class="col-md-3">

                <div class="rw">
                    <label class="file_input" for="left15">Осталось 15 минут</label>
                    <input id="left15" ref="fileInput6" type="file" @change="onFileChange(4)">
                </div>
                <div class="rw">
                    <label class="file_input" for="left10">Осталось 10 минут</label>
                    <input id="left10" ref="fileInput7" type="file" @change="onFileChange(5)">
                </div>
                <div class="rw">
                    <label class="file_input" for="left5">Осталось 5 минут</label>
                    <input id="left5" ref="fileInput8" type="file" @change="onFileChange(6)">
                </div>
                <div class="rw">
                    <label class="file_input" for="Welcome_notif">Приветственное оповещение</label>
                    <input id="Welcome_notif" ref="fileInput9" type="file" @change="onFileChange(7)">
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {createLog} from '../logger';

export default {
    props: ['club_id'],
    data() {
        return {
            sound1: null,
            sound2: null,
            sound3: null,
            sound4: null,
            sound5: null,
            sound6: null,
            sound7: null,
        }
    },
    methods: {
        onFileChange(inputNumber) {
            let numFile     = 'fileInput' + inputNumber;
            const fileInput = this.$refs[numFile];
            const files     = fileInput.files;
            switch (inputNumber) {
                case 1:
                    this.sound1 = files[0];
                    break;
                case 2:
                    this.sound2 = files[0];
                    break;
                case 3:
                    this.sound3 = files[0];
                    break;
                case 4:
                    this.sound4 = files[0];
                    break;
                case 5:
                    this.sound5 = files[0];
                    break;
                case 6:
                    this.sound6 = files[0];
                    break;
                case 7:
                    this.sound7 = files[0];
            }
            console.log(this.files);
        },
        async uploadFiles() {
            const formData = new FormData();
            formData.append('club_id', this.$props.club_id);
            formData.append('sound1', this.sound1);
            formData.append('sound2', this.sound2);
            formData.append('sound3', this.sound3);
            formData.append('sound4', this.sound4);
            formData.append('sound5', this.sound5);
            formData.append('sound6', this.sound6);
            formData.append('sound7', this.sound7);

            try {
                const response = await fetch('/api/sound/upload', {
                    method: 'POST',
                    body  : formData,
                });
                const data     = await response.json();
            } catch (error) {
                console.error(error);
            }
        },
    },
    mounted() {

    }
}
</script>

<style scoped>

.rw {
    margin-bottom : 20px;
}

.file_input {
    display : block;
}

.span-1 {
    margin-top : 14px;
    display    : block;
    font-size  : inherit;
}

.div_4 {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 1px;
    color         : var(--standart-gray);
    border        : none;
    width         : 190px;
    border-radius : 8px;
    font-size     : inherit;
}

.home {
    width       : 1793px;
    color       : var(--standart-gray);
    margin-left : 11px;
    height      : 815px;
}

.home .header {
    display         : flex;
    justify-content : space-between;
}

.home .header .left {
    width : 1060px;
}

.home .header {
    width           : 516px;
    display         : flex;
    justify-content : start;
}

.bottom {
    width         : 1793px;
    height        : 762px;
    background    : var(--light-blue-bg-color);
    margin-top    : 10px;
    border-radius : 20px;
    padding       : 20px;
    margin-left   : 0;
}

.butt {
    background    : var(--disable);
    border        : none;
    border-radius : 5px 30px;
    height        : 42px;
    margin-left   : 20px;
    min-width     : 94px;
    padding-right : 20px;
    padding-left  : 20px;
    display       : inline-block;
}

.butt1 {
    background    : var(--disable);
    border        : none;
    height        : 42px;
    margin-top    : 20px;
    min-width     : 94px;
    padding-right : 20px;
    padding-left  : 20px;
    display       : inline-block;
    border-radius : 5px;
}

.top {
    width   : 235px;
    height  : 42px;
    display : inline-block;
}
</style>
