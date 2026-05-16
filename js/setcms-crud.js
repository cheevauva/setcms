class SetCMSField extends HTMLElement {
    constructor() {
        super();

        this.field = {
            options: [],
            disabled: false,
        };

        for (let i = 0; i < this.attributes.length; i++) {
            const attr = this.attributes[i];
            this.field[attr.name] = attr.value;
        }

        Array.from(this.children).forEach((el) => this.field[el.tagName.toLowerCase()] = el.textContent);

    }
    connectedCallback() {
        this.innerHTML = this.render(this.field);
    }

    render(field) {
        try {
            const templates = {
                hidden: () => this.hidden(field),
                input: () => this.input(field),
                text: () => this.text(field),
                textarea: () => this.textarea(field),
                select: () => this.select(field),
                submit: () => this.submit(field),
                password: () => this.password(field),
                email: () => this.email(field),
                captcha: () => this.captcha(field),
            };


            return templates[field.type] ? templates[field.type]() : '';
        } catch (e) {
            return JSON.stringify(field) + e;
        }

    }

    hidden(field) {
        return `
             <div class="m-0 p-0">
                <input type="hidden" name="${field.name}" value="${field.value}" />
                <div class="invalid-feedback">
            </div>
        `;
    }
    
    text(field) {
        field.type = 'text';
        return this.input(field);
    }
    
    email(field) {
        field.type = 'email';
        return this.input(field);
    }

    password(field) {
        field.type = 'password';
        return this.input(field);
    }

    input(field) {
        return `
        <div class="mb-2">
            ${field.label ? `<label for="${field.name}">${field.label}</label>` : ''}
            <input 
                type="${field.type || ''}" 
                name="${field.name}"  
                value="${field.value || ''}"
                ${field.size ? `size="${field.size}"` : ''} 
                ${field.id ? `id="${field.id}"` : ''}
                ${(field.placeholder || field.title) ? `title="${field.placeholder || field.title}"` : ''}
                ${field.placeholder ? `placeholder="${field.placeholder}"` : ''}
                ${field.disabled ? 'disabled' : ''}
                ${field.required ? 'required' : ''}
                class="form-control ${field.class || ''}"  
            />
            <div class="invalid-feedback"></div>
        </div>
        `;
    }

    textarea(field) {
        return `
        <div class="mb-2">
            ${field.label ? `<label for="${field.name}">${field.label}</label>` : ''}
            <textarea 
                name="${field.name}" 
                id="${field.name}"
                class="form-control ${field.class || ''}"  
                ${field.disabled ? 'disabled' : ''}>${field.value}</textarea>
            <div class="invalid-feedback"></div>
        </div>
        `;
    }

    submit(field) {
        return `
        <div class="mb-2">
            <button class="setcms-submit-button btn btn-primary mb-3" type="button">${field.label}</button>
        </div>
        `;
    }

    select(field) {
        const options = Object.entries(JSON.parse(field.options));

        return `
        <div class="mb-2">
            ${field.label ? `<label for="${field.name}">${field.label}</label>` : ''}
            <select 
                name="${field.name}" 
                ${field.id ? `id="${field.id}"` : ''}
                ${field.disabled ? 'disabled' : ''}
                class="form-control ${field.class || ''}"  
            >
                ${options.map(option => `<option value="${option[0]}" ${option[0] === field.value ? 'selected' : ''}>${option[1]}</option>`).join('')}
            </select>
        </div>
        `;
    }

    captcha(field) {
        console.log(field);
        if (!(field.use || 0)) {
            return '';
        }

        return `
        <div class="setcms-captcha">
            <div class="mb-2">
                <div class="row ml-0 pl-0">
                    <div class="col-md-8 mb-2">
                        <img class="setcms-captcha-image" setcms-action="${field.generate}">
                        <label class="form-label setcms-captcha-image-reload">⟳</label>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                ${field.label ? `<label for="${field.name}" class="form-label">${field.label}</label>` : ''}
                <input name="${field.name}" type="hidden" value="" class="setcms-captcha-captcha-id" setcms-action="${field.solve}">
                <input class="form-control setcms-captcha-solvedtext" title="${field.placeholder || ''}" placeholder="${field.placeholder || ''}" type="text">
                <div class="invalid-feedback"></div>
            </div>
        </div>
        `
    }
}

customElements.define('setcms-field', SetCMSField);

class EditView extends HTMLElement {
    constructor() {
        super();
        this.action = '';
        this.redirect = '';
        this.actions = [];
        this.panels = [];
    }

    connectedCallback() {
        this.action = this.querySelector('action')?.textContent;
        this.redirect = this.querySelector('redirect')?.textContent;
        this.parseContent();
        this.render();
    }

    parseContent() {
        const actionsElem = this.querySelector('actions');

        if (actionsElem) {
            this.actions = actionsElem.querySelectorAll('fields field');
        }

        const panelsElem = this.querySelector('panels');

        if (panelsElem) {
            const panels = panelsElem.querySelectorAll('panel');

            panels.forEach(panelElem => {
                const panel = {
                    name: panelElem.getAttribute('name') || '',
                    label: panelElem.getAttribute('label') || '',
                    active: panelElem.getAttribute('active') === 'true',
                    fields: []
                };

                panel.fields = panelElem.querySelectorAll('fields field');

                this.panels.push(panel);
            });
        }
    }
    // Главный шаблон формы
    renderForm(data) {
        return `
            <form class="setcms-form g-3" setcms-method="POST" setcms-redirect="${data.redirect}" setcms-action="${data.action}">
                ${this.renderTabs(data.panels)}
                ${this.renderTabContent(data.panels)}
                ${this.renderActions(data.actions)}
            </form>
        `;
    }

    // Шаблон навигации по табам
    renderTabs(panels) {
        return `
            <ul class="nav nav-tabs" role="tablist">
                ${panels.map(panel => `
                    <li class="nav-item" role="presentation">
                        <button class="nav-link ${panel.active ? 'active' : ''}" 
                                id="${panel.name}-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#${panel.name}" 
                                type="button" 
                                role="tab">
                            ${panel.label}
                        </button>
                    </li>
                `).join('')}
            </ul>
        `;
    }

    // Шаблон контента табов
    renderTabContent(panels) {
        return `
            <div class="tab-content">
                ${panels.map(panel => `
                    <div class="tab-pane ${panel.active ? 'active' : ''}" 
                         id="${panel.name}" 
                         role="tabpanel">
                         
                        ${Array.from(panel.fields).map(field => this.field(field).outerHTML).join('')}
                    </div>
                `).join('')}
            </div>
        `;
    }

    field(field) {
        const fieldElem = document.createElement('setcms-field');

        if (this.querySelectorAll('options')) {
            fieldElem.setAttribute('options', this.querySelector('options').textContent);
        }

        for (let i = 0; i < field.attributes.length; i++) {
            const attr = field.attributes[i];

            if (typeof attr.value === 'string' || typeof attr.value === 'number') {
                fieldElem.setAttribute(attr.name, attr.value);
            } else if (typeof attr.value === 'boolean') {
                if (attr.value) {
                    fieldElem.setAttribute(attr.name, '');
                }
            } else if (typeof attr.value === 'object') {
                fieldElem.setAttribute(`data-${attr.name}`, JSON.stringify(attr.value));
            }
        }


        return fieldElem;
    }

    renderActions(actions) {
        return Array.from(actions).map(field => this.field(field).outerHTML).join('');
    }

    render() {
        const html = this.renderForm({
            action: this.action,
            redirect: this.redirect,
            actions: this.actions,
            panels: this.panels
        });

        this.innerHTML = html;
    }
}

// Регистрируем компонент


customElements.define('setcms-editview', EditView);
