<template>
    <nav id="Navigationsmenus" class="navbar">
        <ul class="navbar__list">
            <li v-for="item in menuStructure" :key="item.label">
                <a :href="item.link || '#'">{{ item.label }}</a>
                <ul v-if="item.subMenu">
                    <li v-for="subItem in item.subMenu" :key="subItem.label">
                        <a :href="subItem.link || '#'">{{ subItem.label }}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'MenuComponent',
    data() {
        return {
            menuStructure: [
                { label: 'Home', link: '/articles' },
                { label: 'Kategorien', link: '/newarticle' },
                { label: 'Verkaufen', link: '#' },
                {
                    label: 'Unternehmen',
                    subMenu: [
                        { label: 'Philosophie', link: '#' },
                        { label: 'Karriere', link: '#' }
                    ]
                }
            ]
        };
    }
};
</script>

<style scoped lang="scss">
@import "../sass/variables";


// _navbar.scss
.navbar {
    display: flex;
    width: 100%;

    align-items: center;
    background-color: $navbar-bg;
    overflow: hidden;
    justify-content: space-between;
    padding: 0 $navbar-padding-horizontal;

    &__list {
        list-style-type: none;
        padding: 0;
        margin: 0 $navbar-margin-horizontal;
        display: flex;
        justify-content: left;
        gap: $navbar-gap;

        li {
            padding: $list-padding;

            a {
                text-decoration: none;
                color: $link-color;
            }

            &:hover {
                background-color: $hover-bg;
            }
        }
    }
}

// _navigationsmenus.scss
#Navigationsmenus {
    ul {
        list-style-type: none;
        padding: 0;

        ul {
            display: none;
        }

        li:hover > ul {
            display: block;
        }
    }
}

// main.scss


</style>
