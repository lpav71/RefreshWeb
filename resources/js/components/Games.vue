<template>
    <div id="DIV_136">
        <div id="DIV_171">
            <div id="DIV_172">
                <div id="DIV_173">
                    <a id="A_174" href="https://idyllic-griffin-c0f5f9.netlify.app/"><img id="IMG_175" alt='' src="images/top_left.svg"/>Игры и приложения</a>
                    <img id="IMG_177" alt='' src="images/search_002.svg"/>
                    <input id="search_input" v-model="searchGame" placeholder="Поиск" type="text" @keyup="search"/>
                    <div>
                        <button class="btn btn-success">Отображать только добавленный контент</button>
                    </div>
                </div>
                <div>
                    <button class="btn btn-success me-2" @click="add_steam_account">Добавить steam аккаунт</button>
                    <button v-show="permissions.create_game" class="btn btn-success" @click="edit_game">
                        <img alt='' src="images/plus.svg"/> Добавить вручную
                    </button>
                </div>
            </div>
            <div class="game-wrap">
                <div class="scroll">
                    <div id="DIV_195">
                        <div v-for="(game, index) in games" id="icons-game">
                            <div id="game-image">
                                <img id="IMG_200" :src="game.icon" alt=''/>
                                <div id="game-selector">
                                    <button id="game-selector-button" :class="{'game-selector-button-off' : !game.status}" @click="on_off(index)">
                                        <span v-if="game.status">Вкл</span>
                                        <span v-if="!game.status">Выкл</span>
                                    </button>
                                </div>
                            </div>
                            <div id="game-label">
                                <span id="game-name">{{ game.name }}</span>
                                <button id="game-button" @click="edit_game(index)">
                                    <img id="IMG_208" alt='' src="images/edit.svg"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="editGameModal" aria-hidden="true" aria-labelledby="editGameModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content edit-game">
                <div class="modal-header">
                    <h5 id="editGameModalLabel" class="modal-title">Редактирование приложения</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body" style="padding: 0">
                    <div class="main">
                        <div class="div_2">
                            <div class="div_3">
                                <div>
                                    <span class="span-1">Тип приложения</span>
                                    <select v-model="appType" class="div_4">
                                        <option v-for="t in allTypes" :value="t.type">{{ t.name }}</option>
                                    </select></div>
                                <div><span class="span-1">Название игры / приложения</span><input v-model="game.name" class="div_4" type="text"/>
                                </div>
                                <div><span class="span-1">Программа запуска</span><select class="div_4">
                                    <optgroup label="This is a group">
                                        <option selected value="12">This is item 1</option>
                                        <option value="13">This is item 2</option>
                                        <option value="14">This is item 3</option>
                                    </optgroup>
                                </select></div>
                                <div><span class="span-1">Путь до приложения</span><input v-model="game.link" class="div_4" type="text"/></div>
                            </div>
                            <div class="div_3">
                                <div>
                                    <span class="span-1">Использовать лицензии</span>
                                    <select v-model="selectetedLicenses" class="div_4">
                                        <option v-for="u in useLicenses" :value="u.value">{{ u.name }}</option>
                                    </select></div>
                                <div><span class="span-1">Параметры запуска</span><input v-model="game.param" class="div_4" type="text"/></div>
                                <div><span class="span-1">Steam APP ID</span><input v-model="game.steam_id" class="div_4" type="text"/></div>
                                <div><span class="span-1">Путь к изображению</span><input v-model="game.icon" class="div_4 img_path" type="text"/>
                                </div>
                            </div>
                            <div class="div_5" style="margin-top: 15px;">
                                <span class="span-2">Постер</span>
                                <div class="div_8">
                                    <img :src="game.icon" alt="" width="300"/>
                                </div>
                            </div>
                        </div>
                        <div class="div_6">
                            <div class="div_3">
                                <div><span class="span-1">Группы пользователей</span><select class="div_4">
                                    <optgroup label="This is a group">
                                        <option selected value="12">This is item 1</option>
                                        <option value="13">This is item 2</option>
                                        <option value="14">This is item 3</option>
                                    </optgroup>
                                </select></div>
                                <div><span class="span-1">Фильтры</span><select class="div_4">
                                    <optgroup label="This is a group">
                                        <option selected value="12">This is item 1</option>
                                        <option value="13">This is item 2</option>
                                        <option value="14">This is item 3</option>
                                    </optgroup>
                                </select></div>
                            </div>
                            <div class="div_3">
                                <div><span class="span-1">Группы ПК</span>
                                    <select v-model="zone" class="div_4">
                                        <option v-for="zone in zones" :value="zone.num" selected>{{ zone.name }}</option>
                                    </select>
                                </div>
                                <div><span class="span-1">Возрастное ограничение</span><select class="div_4">
                                    <optgroup label="This is a group">
                                        <option selected value="12">This is item 1</option>
                                        <option value="13">This is item 2</option>
                                        <option value="14">This is item 3</option>
                                    </optgroup>
                                </select></div>
                            </div>
                            <div class="div_7" style="margin-top: 15px;">
                                <span class="span-2">Описание</span><textarea v-model="game.description" class="text_1" spellcheck="false"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="save_game">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="addSteamAccountModal" aria-hidden="true" aria-labelledby="addSteamAccountModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="addSteamAccountModalLabel" class="modal-title">Добавление steam аккаунта</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="main_modal2">
                        <div><input v-model="gameName" class="input_1" placeholder="Название игры" type="text"/></div>
                        <div><input v-model="steamId" class="input_1" placeholder="Steam ID" type="text"/></div>
                        <div><input v-model="steamLogin" class="input_1" placeholder="Логин" type="text"/></div>
                        <div><input v-model="steamPassword" class="input_1" placeholder="Пароль" type="text"/></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="save_steam_account">Добавить</button>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>

</template>

<script>

export default {
    props: ['club_id', 'user_id'],
    data() {
        return {
            messages          : [],
            games             : [],
            currentIndex      : 0,
            searchGame        : "",
            modal             : null,
            game              : {},
            mode              : '',
            zones             : [],
            zone              : null,
            allTypes          : [
                {name: 'Игра', type: 0},
                {name: 'Софт', type: 1}
            ],
            appType           : null,
            useLicenses       : [
                {name: 'Да', value: true},
                {name: 'Нет', value: false}
            ],
            selectetedLicenses: null,
            permissions       : {},
            steamAccountModal : null,
            gameName          : '',
            steamId           : '',
            steamLogin        : '',
            steamPassword     : ''
        }
    },
    methods: {
        add_steam_account() {
            this.steamAccountModal.show();
        },
        async save_steam_account() {
            this.steamAccountModal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("gameName", this.gameName);
            urlencoded.append("steamId", this.steamId);
            urlencoded.append("steamLogin", this.steamLogin);
            urlencoded.append("steamPassword", this.steamPassword);
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/games/addsteam", requestOptions);
            if (response.ok) {
                var result    = await response.text();
                var numResult = Number(result);
                if (isNaN(numResult)) {
                    this.$refs.message.modal.show();
                }
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getPermissions() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("user_id", this.$props.user_id);

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
        async addGames() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("zone", this.zone);
            urlencoded.append("id", this.game.id);
            urlencoded.append("name", this.game.name);
            urlencoded.append("link", this.game.link);
            urlencoded.append("param", this.game.param);
            urlencoded.append("steam_id", this.game.steam_id);
            urlencoded.append("club_account", false);
            urlencoded.append("description", this.game.description);
            urlencoded.append('icon', this.game.icon);
            urlencoded.append('type', this.game.type);


            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/map/findpc", requestOptions);
            if (!response.ok) {
                this.$refs.message.modal.show();
            }
        },
        async save_game() {
            this.modal.hide();
            if (this.mode === 'add') {
                // Режим добавления
                this.addGames();
            }
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id", this.game.id);
            urlencoded.append("name", this.game.name);
            urlencoded.append("link", this.game.link);
            urlencoded.append("param", this.game.param);
            urlencoded.append("steam_id", this.game.steam_id);
            urlencoded.append("club_account", false);
            urlencoded.append("description", this.game.description);
            urlencoded.append('club_id', this.$props.club_id);
            urlencoded.append('icon', this.game.icon);
            urlencoded.append('type', this.appType);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/games/savegame", requestOptions);
            if (!response.ok) {
                this.$refs.message.modal.show();
            } else
                this.getGames();
        },
        async getZone() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/zone/getZone", requestOptions);
            if (response.ok) {
                this.zones = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        openModal() {
            var c = this.messages.length;
            if (c > 0) {
                console.log(this.messages[c - 1]);
                this.messages = [];
            }

        },
        async edit_game(i) {
            this.modal.show();
            this.game = {};
            this.getZone();
            if (Number.isFinite(i)) {
                // Редактирование
                this.mode     = 'edit';
                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                var urlencoded = new URLSearchParams();
                urlencoded.append("id", this.games[i].id);

                var requestOptions = {
                    method  : 'POST',
                    headers : myHeaders,
                    body    : urlencoded,
                    redirect: 'follow'
                };
                var response       = await fetch("api/games/getGameById", requestOptions);
                if (response.ok) {
                    this.game               = await response.json();
                    this.selectetedLicenses = this.game.club_account;
                    this.appType            = this.game.type;
                } else {
                    this.$refs.message.modal.show();
                }
            } else {
                this.mode = 'add';
            }
        },
        async search(e) {
            if (e.keyCode === 13) {
                const myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                const urlencoded = new URLSearchParams();
                urlencoded.append("name", this.searchGame);

                const requestOptions = {
                    method  : 'POST',
                    headers : myHeaders,
                    body    : urlencoded,
                    redirect: 'follow'
                };

                const response = await fetch("api/searchGame", requestOptions);
                if (response.ok) {
                    this.games = await response.json();
                } else {
                    this.$refs.message.modal.show();
                }
            }
        },
        async on_off(index) {
            this.games[index].status = !this.games[index].status
            const id                 = this.games[index].id;
            const status             = this.games[index].status;

            const myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            const urlencoded = new URLSearchParams();
            urlencoded.append("status", status);
            urlencoded.append("id", id);

            const requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/changeStatus", requestOptions);
            if (!response.ok) {
                this.$refs.message.modal.show();
            }
        },
        async getGames() {
            const urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            const requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            const response = await fetch("api/getGames", requestOptions);
            if (response.ok) {
                this.games = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
    },
    mounted() {
        // PUSHER ---------------------------------------------
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('6a5d1d953f639e0236dc', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            this.messages.push(JSON.stringify(data));
        }.bind(this));
        // ~PUSHER ---------------------------------------------

        var editGameModal = document.getElementById('editGameModal')
        this.modal        = bootstrap.Modal.getOrCreateInstance(editGameModal);

        var addSteamAccountModal = document.getElementById('addSteamAccountModal')
        this.steamAccountModal   = bootstrap.Modal.getOrCreateInstance(addSteamAccountModal);

        this.getGames();
        this.getPermissions();

        setInterval(this.openModal, 2000);
    }
}
</script>

<style scoped>

.main {
    width  : 800px;
    height : 583px;
}

.main_modal2 {
    height          : 236px;
    display         : flex;
    flex-direction  : column;
    justify-content : space-around;
    padding         : 10px;
}

.bt {
    background : var(--regular);
    color      : var(--standart-gray);
}

.input_1 {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 1px;
    color         : var(--standart-gray);
    border        : none;
    width         : 100%;
    border-radius : 8px;
    font-size     : 12px;
}

.right_block {
    display : flex;
}

.add_steam {
    background    : var(--regular);
    color         : var(--table-color);
    border-radius : 5px 30px 5px 30px;
    font-size     : 16px;
}

.scroll {
    height   : 815px;
    width    : 1770px;
    overflow : auto;
    position : relative;
    top      : 20px;
    bottom   : 20px;
}

.div_2 {
    height              : 393px;
    display             : flex;
    color               : var(--standart-gray);
    border-bottom-width : 1px;
    border-bottom-style : solid;
    border-color        : #172d39;
}

.div_6 {
    height  : 188px;
    display : flex;
    color   : var(--standart-gray);
}

.div_3 {
    width       : 220px;
    height      : 171px;
    display     : inline-block;
    padding     : 12px;
    margin-left : 10px;
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
    font-size     : 12px;
}

.div_5 {
    width          : 321px;
    padding        : 12px;
    height         : 366px;
    display        : flex;
    flex-direction : column;
}

.div_8 {
    overflow      : hidden;
    border-radius : 10px;
}

.div_7 {
    width          : 323px;
    padding        : 12px;
    height         : 160px;
    display        : flex;
    flex-direction : column;
}

.check-1 + label {
    display     : inline-flex;
    align-items : center;
    user-select : none;
}

.check-1 + label::after {
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

.check-1:checked + label::after {
    border-color     : #0b76ef;
    background-color : #0b76ef;
    background-image : url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

.check-2 + label {
    display     : inline-flex;
    align-items : center;
    user-select : none;
}

.check-2 + label::after {
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

.check-2:checked + label::after {
    border-color     : #0b76ef;
    background-color : #0b76ef;
    background-image : url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

.span-1 {
    margin-top : 14px;
    display    : inline-block;
    font-size  : 12px;
}

.span-2 {
    display   : inline-block;
    font-size : 12px;
}

.text_1 {
    background    : #172d39;
    margin-top    : 1px;
    color         : var(--standart-gray);
    border        : none;
    border-radius : 8px;
    font-size     : 12px;
    line-height   : 1.1em;
    padding       : 5px;
    height        : 108px;
    width         : 305px;
}

.edit-game {
    background : var(--dark-green-b);
    color      : var(--standart-gray);
}

.game-wrap {
    background    : var(--light-blue-bg-color);
    height        : 752px;
    width         : 1793px;
    padding-left  : 20px;
    border-radius : 20px;
    margin-top    : 20px;
}

#icons-game {
    margin-right  : 21px;
    margin-bottom : 30px;
}

#game-button {
    border     : none;
    background : none;
}

#IMG_200 {
    display : block;
    width   : 156px;
    height  : 200px;
}

#game-name {
    color : white;
}

#game-label {
    display         : flex;
    justify-content : space-between;
    width           : 156px;
}

#game-selector-button {
    display         : flex;
    justify-content : center;
    float           : right;
    height          : 29px;
    width           : 28px;
    z-index         : 2;
    background      : rgb(51, 140, 144) none repeat scroll 0 0 / auto padding-box border-box;
    border          : 0 none rgb(255, 255, 255);
    border-radius   : 10px;
    transition      : all 0.5s ease 0s;
    position        : relative;
}

#game-selector {
    position      : relative;
    height        : 30px;
    background    : #2f2f2f;
    width         : 60px;
    border-radius : 10px;
    font-size     : 10px;
    margin-top    : -70px;
    margin-bottom : 46px;
    margin-left   : 52px;
}

#game-selector span {
    color : white;
}

#DIV_136 {
    width       : 1813px;
    height      : 815px;
    padding     : 0 20px;
    margin-left : -9px;
}

#DIV_172 {
    align-items               : center;
    block-size                : 42px;
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    display                   : flex;
    height                    : 42px;
    inline-size               : 1770px;
    justify-content           : space-between;
    perspective-origin        : 885px 21px;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    transform-origin          : 885px 21px;
    width                     : 1793px;
    border                    : 0 none rgb(33, 37, 41);
    outline                   : rgb(33, 37, 41) none 0;
}

/*#DIV_172*/

#DIV_172:after {
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    display                   : block;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(33, 37, 41);
    outline                   : rgb(33, 37, 41) none 0;
}

/*#DIV_172:after*/

#DIV_172:before {
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    display                   : block;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(33, 37, 41);
    outline                   : rgb(33, 37, 41) none 0;
}

/*#DIV_172:before*/

#DIV_173 {
    align-items : center;
    display     : flex;
    height      : 42px;
    width       : 70rem;
}

#A_174 {
    align-items     : center;
    color           : rgb(246, 246, 247);
    display         : flex;
    text-decoration : none solid rgb(246, 246, 247);
    width           : 260px;
    margin-right    : 10rem;
}

#IMG_175 {
    block-size                : 16px;
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;
    display                   : block;
    height                    : 16px;
    inline-size               : 16px;
    margin-inline-end         : 10px;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    perspective-origin        : 8px 8px;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    transform-origin          : 8px 8px;
    vertical-align            : middle;
    width                     : 16px;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    margin                    : 0 10px 0 0;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#IMG_175*/

#IMG_175:after {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;

    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
    overflow                  : visible;
}

/*#IMG_175:after*/

#IMG_175:before {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;

    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
    overflow                  : visible;
}

#IMG_177 {
    block-size                : 16px;
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    display                   : block;
    height                    : 16px;
    inline-size               : 16px;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    perspective-origin        : 8px 8px;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    transform-origin          : 8px 8px;
    vertical-align            : middle;
    width                     : 16px;
    border                    : 0 none rgb(33, 37, 41);

    outline                   : rgb(33, 37, 41) none 0;
}

/*#IMG_177*/

#IMG_177:after {
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);

    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(33, 37, 41);

    outline                   : rgb(33, 37, 41) none 0;
    overflow                  : visible;
}

/*#IMG_177:after*/

#IMG_177:before {
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);

    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(33, 37, 41);

    outline                   : rgb(33, 37, 41) none 0;
    overflow                  : visible;
}

/*#IMG_177:before*/

#search_input {
    block-size                : 22px;
    border-block-end-color    : rgb(198, 198, 198);
    border-block-end-style    : none;
    border-block-end-width    : 0;
    border-block-start-color  : rgb(198, 198, 198);
    border-block-start-style  : none;
    border-block-start-width  : 0;
    border-inline-end-color   : rgb(198, 198, 198);
    border-inline-end-style   : none;
    border-inline-end-width   : 0;
    border-inline-start-color : rgb(198, 198, 198);
    border-inline-start-style : none;
    border-inline-start-width : 0;
    caret-color               : rgb(198, 198, 198);
    color                     : rgb(198, 198, 198);
    column-rule-color         : rgb(198, 198, 198);
    display                   : block;
    height                    : 22px;
    inline-size               : 194px;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    padding-block-end         : 0;
    padding-block-start       : 0;
    padding-inline-end        : 0;
    padding-inline-start      : 0;
    perspective-origin        : 97px 11px;
    text-decoration           : none solid rgb(198, 198, 198);
    text-emphasis-color       : rgb(198, 198, 198);
    text-size-adjust          : 100%;
    transform-origin          : 97px 11px;
    width                     : 194px;
    background                : rgba(0, 0, 0, 0) none repeat scroll 0 0 / auto padding-box border-box;
    border                    : 0 none rgb(198, 198, 198);

    outline                   : rgb(198, 198, 198) none 0;
    padding                   : 0;
}

/*#search_input*/

#search_input:after {
    border-block-end-color    : rgb(198, 198, 198);
    border-block-start-color  : rgb(198, 198, 198);
    border-inline-end-color   : rgb(198, 198, 198);
    border-inline-start-color : rgb(198, 198, 198);
    box-sizing                : border-box;
    caret-color               : rgb(198, 198, 198);
    color                     : rgb(198, 198, 198);
    column-rule-color         : rgb(198, 198, 198);
    text-decoration           : none solid rgb(198, 198, 198);
    text-emphasis-color       : rgb(198, 198, 198);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(198, 198, 198);

    outline                   : rgb(198, 198, 198) none 0;
}

/*#search_input:after*/

#search_input:before {
    border-block-end-color    : rgb(198, 198, 198);
    border-block-start-color  : rgb(198, 198, 198);
    border-inline-end-color   : rgb(198, 198, 198);
    border-inline-start-color : rgb(198, 198, 198);
    box-sizing                : border-box;
    caret-color               : rgb(198, 198, 198);
    color                     : rgb(198, 198, 198);
    column-rule-color         : rgb(198, 198, 198);
    text-decoration           : none solid rgb(198, 198, 198);
    text-emphasis-color       : rgb(198, 198, 198);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(198, 198, 198);

    outline                   : rgb(198, 198, 198) none 0;
}

/*#search_input:before*/

#DIV_179 {
    block-size                : 42px;
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-end-end-radius     : 6px;
    border-end-start-radius   : 6px;
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    border-start-end-radius   : 6px;
    border-start-start-radius : 6px;
    bottom                    : 0;
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    display                   : flex;
    height                    : 42px;
    inline-size               : 122px;
    inset-block-end           : 0;
    inset-block-start         : 0;
    inset-inline-end          : 0;
    inset-inline-start        : 0;
    left                      : 0;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    perspective-origin        : 61px 21px;
    position                  : relative;
    right                     : 0;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    top                       : 0;
    transform-origin          : 61px 21px;
    vertical-align            : middle;
    width                     : 122px;
    border                    : 0 none rgb(33, 37, 41);
    border-radius             : 6px;

    outline                   : rgb(33, 37, 41) none 0;
}

/*#DIV_179*/

#DIV_179:after {
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    display                   : block;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(33, 37, 41);

    outline                   : rgb(33, 37, 41) none 0;
}

/*#DIV_179:after*/

#DIV_179:before {
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    display                   : block;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(33, 37, 41);

    outline                   : rgb(33, 37, 41) none 0;
}

/*#DIV_179:before*/

#BUTTON_180 {
    align-items               : center;
    block-size                : 42px;
    border-block-end-color    : rgb(246, 246, 247);
    border-block-end-style    : none;
    border-block-end-width    : 0;
    border-block-start-color  : rgb(246, 246, 247);
    border-block-start-style  : none;
    border-block-start-width  : 0;
    border-end-end-radius     : 5px;
    border-end-start-radius   : 30px;
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-end-style   : none;
    border-inline-end-width   : 0;
    border-inline-start-color : rgb(246, 246, 247);
    border-inline-start-style : none;
    border-inline-start-width : 0;
    border-start-end-radius   : 30px;
    border-start-start-radius : 5px;
    bottom                    : 0;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-gap                : 10px;
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;
    display                   : flex;
    height                    : 42px;
    inline-size               : 122px;
    inset-block-end           : 0;
    inset-block-start         : 0;
    inset-inline-end          : 0;
    inset-inline-start        : 0;
    left                      : 0;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    padding-block-end         : 10px;
    padding-block-start       : 10px;
    padding-inline-end        : 20px;
    padding-inline-start      : 20px;
    perspective-origin        : 61px 21px;
    position                  : relative;
    right                     : 0;
    row-gap                   : 10px;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    top                       : 0;
    transform-origin          : 61px 21px;
    user-select               : none;
    vertical-align            : middle;
    white-space               : nowrap;
    width                     : 122px;
    background                : rgb(51, 140, 144) none repeat scroll 0 0 / auto padding-box border-box;
    border                    : 0 none rgb(246, 246, 247);
    border-radius             : 5px 30px;
    flex                      : 1 1 auto;
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
    padding                   : 10px 20px;
    transition                : all 0.4s ease 0s;
}

/*#BUTTON_180*/

#BUTTON_180:after {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-block-start-style  : solid;
    border-block-start-width  : 4px;
    border-inline-end-color   : rgba(0, 0, 0, 0);
    border-inline-end-style   : solid;
    border-inline-end-width   : 4px;
    border-inline-start-color : rgba(0, 0, 0, 0);
    border-inline-start-style : solid;
    border-inline-start-width : 4px;
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    content                   : '""';
    cursor                    : pointer;
    display                   : none;
    margin-inline-start       : 4px;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    user-select               : none;
    vertical-align            : 4px;
    white-space               : nowrap;
    border-top                : 4px solid rgb(246, 246, 247);
    border-right              : 4px solid rgba(0, 0, 0, 0);
    border-bottom             : 0 none rgb(246, 246, 247);
    border-left               : 4px solid rgba(0, 0, 0, 0);
    font                      : 16px / 22px Russia, sans-serif;
    margin                    : 0 0 0 4px;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#BUTTON_180:after*/

#BUTTON_180:before {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;
    display                   : block;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    user-select               : none;
    white-space               : nowrap;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#BUTTON_180:before*/

#IMG_181 {
    block-size                : 8px;
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;
    display                   : block;
    height                    : 8px;
    inline-size               : 12px;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    perspective-origin        : 6px 4px;
    text-align                : center;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    transform-origin          : 6px 4px;
    user-select               : none;
    vertical-align            : middle;
    white-space               : nowrap;
    width                     : 12px;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#IMG_181*/

#IMG_181:after {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;

    text-align                : center;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    user-select               : none;
    white-space               : nowrap;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
    overflow                  : visible;
}

/*#IMG_181:after*/

#IMG_181:before {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;

    text-align                : center;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    user-select               : none;
    white-space               : nowrap;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
    overflow                  : visible;
}

/*#IMG_181:before*/

#UL_182 {
    border-block-end-color    : rgba(0, 0, 0, 0.176);
    border-block-end-style    : solid;
    border-block-end-width    : 1px;
    border-block-start-color  : rgba(0, 0, 0, 0.176);
    border-block-start-style  : solid;
    border-block-start-width  : 1px;
    border-end-end-radius     : 5px;
    border-end-start-radius   : 30px;
    border-inline-end-color   : rgba(0, 0, 0, 0.176);
    border-inline-end-style   : solid;
    border-inline-end-width   : 1px;
    border-inline-start-color : rgba(0, 0, 0, 0.176);
    border-inline-start-style : solid;
    border-inline-start-width : 1px;
    border-start-end-radius   : 30px;
    border-start-start-radius : 5px;
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    display                   : none;
    margin-block-end          : 0;
    margin-block-start        : 0;
    min-inline-size           : 160px;
    min-width                 : 160px;
    padding-block-end         : 10px;
    padding-block-start       : 10px;
    padding-inline-end        : 10px;
    padding-inline-start      : 10px;
    position                  : absolute;
    text-align                : left;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    z-index                   : 1000;
    background                : rgb(51, 140, 144) none repeat scroll 0 0 / auto padding-box border-box;
    border                    : 1px solid rgba(0, 0, 0, 0.176);
    border-radius             : 5px 30px;

    list-style                : outside none none;
    margin                    : 0;
    outline                   : rgb(33, 37, 41) none 0;
    padding                   : 10px;
}

/*#UL_182*/

#UL_182:after {
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    text-align                : left;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(33, 37, 41);

    list-style                : outside none none;
    outline                   : rgb(33, 37, 41) none 0;
}

/*#UL_182:after*/

#UL_182:before {
    border-block-end-color    : rgb(33, 37, 41);
    border-block-start-color  : rgb(33, 37, 41);
    border-inline-end-color   : rgb(33, 37, 41);
    border-inline-start-color : rgb(33, 37, 41);
    box-sizing                : border-box;
    caret-color               : rgb(33, 37, 41);
    color                     : rgb(33, 37, 41);
    column-rule-color         : rgb(33, 37, 41);
    text-align                : left;
    text-decoration           : none solid rgb(33, 37, 41);
    text-emphasis-color       : rgb(33, 37, 41);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(33, 37, 41);

    list-style                : outside none none;
    outline                   : rgb(33, 37, 41) none 0;
}

/*#UL_182:before*/

#A_184, #A_186 {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    clear                     : both;
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    display                   : block;
    inline-size               : 100%;
    padding-block-start       : 3px;
    text-align                : left;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    white-space               : nowrap;
    width                     : 100%;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    list-style                : outside none none;
    outline                   : rgb(246, 246, 247) none 0;
    padding                   : 3px 0 0;
}

/*#A_184, #A_186*/

#A_184:after, #A_186:after {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    text-align                : left;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    white-space               : nowrap;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    list-style                : outside none none;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#A_184:after, #A_186:after*/

#A_184:before, #A_186:before {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    text-align                : left;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    white-space               : nowrap;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    list-style                : outside none none;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#A_184:before, #A_186:before*/

#A_188 {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    clear                     : both;
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    display                   : block;
    inline-size               : 100%;
    padding-block-start       : 3px;
    text-align                : left;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    white-space               : nowrap;
    width                     : 100%;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    list-style                : outside none none;
    outline                   : rgb(246, 246, 247) none 0;
    padding                   : 3px 0 0;
}

/*#A_188*/

#A_188:after {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    text-align                : left;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    white-space               : nowrap;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    list-style                : outside none none;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#A_188:after*/

#A_188:before {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    text-align                : left;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    white-space               : nowrap;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    list-style                : outside none none;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#A_188:before*/

#DIV_189 {
    align-items               : center;
    block-size                : 42px;
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-end-end-radius     : 5px;
    border-end-start-radius   : 30px;
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    border-start-end-radius   : 30px;
    border-start-start-radius : 5px;
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-gap                : 10px;
    column-rule-color         : rgb(246, 246, 247);
    display                   : flex;
    height                    : 42px;
    inline-size               : 376px;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    padding-block-end         : 10px;
    padding-block-start       : 10px;
    padding-inline-end        : 20px;
    padding-inline-start      : 20px;
    perspective-origin        : 188px 21px;
    row-gap                   : 10px;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    transform-origin          : 188px 21px;
    width                     : 376px;
    background                : rgb(51, 140, 144) none repeat scroll 0 0 / auto padding-box border-box;
    border                    : 0 none rgb(246, 246, 247);
    border-radius             : 5px 30px;
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
    padding                   : 10px 20px;
    transition                : all 0.5s ease 0s;
}

/*#DIV_189*/

#DIV_189:after {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    display                   : block;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#DIV_189:after*/

#DIV_189:before {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    display                   : block;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#DIV_189:before*/

#LABEL_190 {
    block-size                : 22px;
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;
    display                   : block;
    height                    : 22px;
    inline-size               : 311px;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    perspective-origin        : 155px 11px;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    transform-origin          : 155px 11px;
    width                     : 311px;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#LABEL_190*/

#LABEL_190:after {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#LABEL_190:after*/

#LABEL_190:before {
    border-block-end-color    : rgb(246, 246, 247);
    border-block-start-color  : rgb(246, 246, 247);
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-start-color : rgb(246, 246, 247);
    box-sizing                : border-box;
    caret-color               : rgb(246, 246, 247);
    color                     : rgb(246, 246, 247);
    column-rule-color         : rgb(246, 246, 247);
    cursor                    : pointer;
    text-decoration           : none solid rgb(246, 246, 247);
    text-emphasis-color       : rgb(246, 246, 247);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(246, 246, 247);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(246, 246, 247) none 0;
}

/*#LABEL_190:before*/

#INPUT_191 {
    appearance                : none;
    background-position       : 50% 50%;
    block-size                : 15px;
    border-block-end-color    : rgb(246, 246, 247);
    border-block-end-style    : solid;
    border-block-end-width    : 1px;
    border-block-start-color  : rgb(246, 246, 247);
    border-block-start-style  : solid;
    border-block-start-width  : 1px;
    border-end-end-radius     : 4px;
    border-end-start-radius   : 4px;
    border-inline-end-color   : rgb(246, 246, 247);
    border-inline-end-style   : solid;
    border-inline-end-width   : 1px;
    border-inline-start-color : rgb(246, 246, 247);
    border-inline-start-style : solid;
    border-inline-start-width : 1px;
    border-start-end-radius   : 4px;
    border-start-start-radius : 4px;
    cursor                    : pointer;
    display                   : block;
    height                    : 15px;
    inline-size               : 15px;
    margin-block-start        : 4px;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    padding-block-end         : 0;
    padding-block-start       : 0;
    padding-inline-end        : 0;
    padding-inline-start      : 0;
    perspective-origin        : 8px 8px;
    text-size-adjust          : 100%;
    transform-origin          : 8px 8px;
    vertical-align            : top;
    width                     : 15px;
    border                    : 1px solid rgb(246, 246, 247);
    border-radius             : 4px;
    font                      : 16px / 22px Russia, sans-serif;
    margin                    : 4px 0 0;
    padding                   : 0;
}

/*#INPUT_191*/

#INPUT_191:after {
    box-sizing       : border-box;
    cursor           : pointer;
    text-size-adjust : 100%;
    font             : 16px / 22px Russia, sans-serif;
}

/*#INPUT_191:after*/

#INPUT_191:before {
    box-sizing       : border-box;
    cursor           : pointer;
    text-size-adjust : 100%;
    font             : 16px / 22px Russia, sans-serif;
}

/*#INPUT_191:before*/

#BUTTON_193 {
    align-items               : center;
    block-size                : 42px;
    border-block-end-color    : rgb(255, 255, 255);
    border-block-end-style    : none;
    border-block-end-width    : 0;
    border-block-start-color  : rgb(255, 255, 255);
    border-block-start-style  : none;
    border-block-start-width  : 0;
    border-end-end-radius     : 5px;
    border-end-start-radius   : 30px;
    border-inline-end-color   : rgb(255, 255, 255);
    border-inline-end-style   : none;
    border-inline-end-width   : 0;
    border-inline-start-color : rgb(255, 255, 255);
    border-inline-start-style : none;
    border-inline-start-width : 0;
    border-start-end-radius   : 30px;
    border-start-start-radius : 5px;
    caret-color               : rgb(255, 255, 255);
    color                     : rgb(255, 255, 255);
    column-gap                : 10px;
    column-rule-color         : rgb(255, 255, 255);
    cursor                    : pointer;
    display                   : flex;
    height                    : 42px;
    inline-size               : 206px;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    padding-block-end         : 10px;
    padding-block-start       : 10px;
    padding-inline-end        : 20px;
    padding-inline-start      : 20px;
    perspective-origin        : 103px 21px;
    row-gap                   : 10px;
    text-decoration           : none solid rgb(255, 255, 255);
    text-emphasis-color       : rgb(255, 255, 255);
    text-size-adjust          : 100%;
    transform-origin          : 103px 21px;
    width                     : 206px;
    background                : rgb(51, 140, 144) none repeat scroll 0 0 / auto padding-box border-box;
    border                    : 0 none rgb(255, 255, 255);
    border-radius             : 5px 30px;
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(255, 255, 255) none 0;
    padding                   : 10px 20px;
    transition                : all 0.4s ease 0s;
}

#BUTTON_193:after {
    border-block-end-color    : rgb(255, 255, 255);
    border-block-start-color  : rgb(255, 255, 255);
    border-inline-end-color   : rgb(255, 255, 255);
    border-inline-start-color : rgb(255, 255, 255);
    box-sizing                : border-box;
    caret-color               : rgb(255, 255, 255);
    color                     : rgb(255, 255, 255);
    column-rule-color         : rgb(255, 255, 255);
    cursor                    : pointer;
    display                   : block;
    text-decoration           : none solid rgb(255, 255, 255);
    text-emphasis-color       : rgb(255, 255, 255);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(255, 255, 255);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(255, 255, 255) none 0;
}

#BUTTON_193:before {
    border-block-end-color    : rgb(255, 255, 255);
    border-block-start-color  : rgb(255, 255, 255);
    border-inline-end-color   : rgb(255, 255, 255);
    border-inline-start-color : rgb(255, 255, 255);
    box-sizing                : border-box;
    caret-color               : rgb(255, 255, 255);
    color                     : rgb(255, 255, 255);
    column-rule-color         : rgb(255, 255, 255);
    cursor                    : pointer;
    display                   : block;
    text-decoration           : none solid rgb(255, 255, 255);
    text-emphasis-color       : rgb(255, 255, 255);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(255, 255, 255);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(255, 255, 255) none 0;
}

#IMG_194 {
    block-size                : 18px;
    border-block-end-color    : rgb(255, 255, 255);
    border-block-start-color  : rgb(255, 255, 255);
    border-inline-end-color   : rgb(255, 255, 255);
    border-inline-start-color : rgb(255, 255, 255);
    box-sizing                : border-box;
    caret-color               : rgb(255, 255, 255);
    color                     : rgb(255, 255, 255);
    column-rule-color         : rgb(255, 255, 255);
    cursor                    : pointer;
    display                   : block;
    height                    : 18px;
    inline-size               : 18px;
    min-block-size            : auto;
    min-height                : auto;
    min-inline-size           : auto;
    min-width                 : auto;
    perspective-origin        : 9px 9px;
    text-align                : center;
    text-decoration           : none solid rgb(255, 255, 255);
    text-emphasis-color       : rgb(255, 255, 255);
    text-size-adjust          : 100%;
    transform-origin          : 9px 9px;
    vertical-align            : middle;
    width                     : 18px;
    border                    : 0 none rgb(255, 255, 255);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(255, 255, 255) none 0;
}

#IMG_194:after {
    border-block-end-color    : rgb(255, 255, 255);
    border-block-start-color  : rgb(255, 255, 255);
    border-inline-end-color   : rgb(255, 255, 255);
    border-inline-start-color : rgb(255, 255, 255);
    box-sizing                : border-box;
    caret-color               : rgb(255, 255, 255);
    color                     : rgb(255, 255, 255);
    column-rule-color         : rgb(255, 255, 255);
    cursor                    : pointer;

    text-align                : center;
    text-decoration           : none solid rgb(255, 255, 255);
    text-emphasis-color       : rgb(255, 255, 255);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(255, 255, 255);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(255, 255, 255) none 0;
    overflow                  : visible;
}

#IMG_194:before {
    border-block-end-color    : rgb(255, 255, 255);
    border-block-start-color  : rgb(255, 255, 255);
    border-inline-end-color   : rgb(255, 255, 255);
    border-inline-start-color : rgb(255, 255, 255);
    box-sizing                : border-box;
    caret-color               : rgb(255, 255, 255);
    color                     : rgb(255, 255, 255);
    column-rule-color         : rgb(255, 255, 255);
    cursor                    : pointer;

    text-align                : center;
    text-decoration           : none solid rgb(255, 255, 255);
    text-emphasis-color       : rgb(255, 255, 255);
    text-size-adjust          : 100%;
    border                    : 0 none rgb(255, 255, 255);
    font                      : 16px / 22px Russia, sans-serif;
    outline                   : rgb(255, 255, 255) none 0;
    overflow                  : visible;
}

#DIV_195 {
    display   : flex;
    flex-wrap : wrap;
}

.game-selector-button-off {
    float      : left !important;
    background : #820303 !important;
}
</style>
