// Menüstruktur in JavaScript definieren
/*const menuStructure = [
    { label: 'Home', link: '/articles' },
    { label: 'Kategorien', link: '/newarticle' },
    { label: 'Verkaufen', link: '#' },
    { label: 'Unternehmen', subMenu: [
            { label: 'Philosophie', link: '#' },
            { label: 'Karriere', link: '#' }
        ]}
];

// Funktion zur Erstellung des Menüs
function createMenu(menuData, parentElement) {
    const ul = document.createElement('ul');

    menuData.forEach(item => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.textContent = item.label;
        a.href = item.link || '#'; // Setzen Sie den Link oder "#" als Standardwert
        li.appendChild(a);

        // Wenn das Element ein Untermenü hat, rekursiv ein Untermenü erstellen
        if (item.subMenu) {
            createMenu(item.subMenu, li);
        }

        ul.appendChild(li);
    });

    parentElement.appendChild(ul);
}

// Menü erstellen und in das HTML einfügen
const navMenu = document.getElementById('Navigationsmenus'); // Nehmen Sie an, dass es ein Element mit der ID 'navMenu' gibt
createMenu(menuStructure, navMenu);*/

'use strict'
class Menu {
    constructor(menuStructure, containerId) {
        this.menuStructure = menuStructure;
        this.container = document.getElementById(containerId);
        this.menu = document.createElement('ul');
        this.buildMenu();
    }

    buildMenu() {
        this.menuStructure.forEach(item => {
            const menuItem = document.createElement('li');
            this.menu.appendChild(menuItem);
            const link = document.createElement('a');
            link.textContent = item.label;
            link.setAttribute('href', item.url || '#'); // Default to '#' if URL is not provided
            menuItem.appendChild(link);
            if (item.children) {
                const subMenu = document.createElement('ul');
                item.children.forEach(subItem => {
                    const subMenuItem = document.createElement('li');
                    subMenu.appendChild(subMenuItem);
                    const subLink = document.createElement('a');
                    subLink.textContent = subItem.label;
                    subLink.setAttribute('href', subItem.url || '#'); // Default to '#' if URL is not provided
                    subMenuItem.appendChild(subLink);
                });
                menuItem.appendChild(subMenu);
            }
        });
        this.container.appendChild(this.menu);
    }
}

// Define the menu structure in JavaScript
const menuStructure = [
    { label: 'Home' },
    { label: 'Kategorien', link: '/newarticle' },
    { label: 'Verkaufen'},
    {
        label: 'Unternehmen',
        children: [
            { label: 'Philosophie' },
            { label: 'Karriere' }
        ]
    }
];

// Create an instance of the Menu class
const menu = new Menu(menuStructure, 'Navigationsmenus');
