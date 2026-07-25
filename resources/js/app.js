window.YLStore = window.YLStore || {};

window.YLStore.deliveryOrderForm = (config) => ({
    wilayas: [],
    communes: [],
    wilayaId: String(config.oldWilayaId || ''),
    communeId: String(config.oldCommuneId || ''),
    quantity: Number(config.initialQuantity || 1),
    maxQuantity: Number(config.maxQuantity || 1),
    productPrice: Number(config.productPrice || 0),
    loadingWilayas: false,
    loadingCommunes: false,

    async init() {
        await this.loadWilayas();

        if (this.wilayaId) {
            await this.loadCommunes();
        }
    },

    get selectedWilaya() {
        return this.wilayas.find((wilaya) => String(wilaya.id) === String(this.wilayaId));
    },

    get deliveryPrice() {
        return Number(this.selectedWilaya?.delivery_price || 0);
    },

    get safeQuantity() {
        const quantity = Number(this.quantity || 1);

        return Math.min(this.maxQuantity, Math.max(1, quantity));
    },

    get itemsTotal() {
        return this.productPrice * this.safeQuantity;
    },

    get estimatedTotal() {
        return this.itemsTotal + this.deliveryPrice;
    },

    get communePlaceholder() {
        if (!this.wilayaId) {
            return 'Choose wilaya first';
        }

        if (this.loadingCommunes) {
            return 'Loading communes...';
        }

        return this.communes.length ? 'Choose commune' : 'No communes available';
    },

    communeLabel(commune) {
        return commune.daira_name ? `${commune.name} - ${commune.daira_name}` : commune.name;
    },

    formatPrice(value) {
        return new Intl.NumberFormat('fr-DZ', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(Number(value || 0));
    },

    async loadWilayas() {
        this.loadingWilayas = true;

        try {
            const response = await fetch(config.wilayasUrl, {
                headers: { Accept: 'application/json' },
            });
            const payload = await response.json();

            this.wilayas = payload.data || [];
        } finally {
            this.loadingWilayas = false;
        }
    },

    async loadCommunes() {
        this.communes = [];

        if (!this.wilayaId) {
            return;
        }

        this.loadingCommunes = true;

        try {
            const response = await fetch(config.communesUrlTemplate.replace('__WILAYA__', this.wilayaId), {
                headers: { Accept: 'application/json' },
            });
            const payload = await response.json();

            this.communes = payload.data || [];
        } finally {
            this.loadingCommunes = false;
        }
    },
});
