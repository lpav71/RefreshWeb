<template>
    <div class="menu">
        <div v-for="item in menuItems" :key="item.id" :class="{'selected-item': item.showSubMenu}" class="menu-item" @click="toggleSubMenu($event, item)">
            {{ item.name }}
            <span v-if="item.subMenu">-></span>
            <div v-if="item.subMenu && item.showSubMenu" :style="{top: top + 'px'}" class="sub-menu">
                <div v-for="subItem in item.subMenu" :key="subItem.id" class="sub-menu-item">
                    {{ subItem.name }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MultiLevelMenu',
    data() {
        return {
            menuItems: [
                {
                    id         : 1,
                    name       : 'Item 1',
                    showSubMenu: false
                },
                {
                    id         : 2,
                    name       : 'Menu Item 2',
                    subMenu    : [
                        {
                            id  : 1,
                            name: 'Sub Menu Item 1'
                        },
                        {
                            id  : 2,
                            name: 'Sub Menu Item 2'
                        }
                    ],
                    showSubMenu: false
                },
                {
                    id         : 3,
                    name       : 'Menu Item 3',
                    subMenu    : [
                        {
                            id  : 1,
                            name: 'Sub Menu Item 1'
                        },
                        {
                            id  : 2,
                            name: 'Sub Menu Item 2'
                        }
                    ],
                    showSubMenu: false
                }
            ],
            top      : 0
        }
    },
    methods: {
        toggleSubMenu(e, item) {
            this.top = e.target.offsetTop;
            if (item.showSubMenu == true) {
                this.menuItems.forEach(function (item) {
                    item.showSubMenu = false;
                })
            } else {
                this.menuItems.forEach(function (item) {
                    item.showSubMenu = false;
                })
                item.showSubMenu = true;
            }
            console.log(item.id);
        }
    }
}
</script>

<style>
.menu {
    display        : flex;
    flex-direction : column;
    background     : var(--light-blue-bg-color);
    width          : 180px;
    border-radius  : 10px;
    padding        : 15px;
    position       : absolute;
    color          : white;
}

.sub-menu {
    display        : flex;
    flex-direction : column;
    background     : var(--light-blue-bg-color);
    width          : 180px;
    border-radius  : 10px;
    padding        : 5px;
    position       : absolute;
    left           : 183px;
}

.menu-item {
    cursor      : pointer;
    height      : 30px;
    padding     : 5px;
    user-select : none;
}

.menu-item:hover {
    background    : green;
    border-radius : 10px;
}

.sub-menu-item {
    padding-left : 10px;
    user-select  : none;
}

.selected-item {
    background    : #005f74;
    border-radius : 10px;
}
</style>
