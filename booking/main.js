Vue.createApp({
    data() {
        return{
            tableCount: null,
            seats: [],

            isTableCreated: false,

            bookingId: null,

            bookingInfo: {
                name:null,
                phone:null,
                seats:null,
                time:null,
            },
            
            bookingData:[],
        };
    },
    methods: {
        createTable() {
            this.isTableCreated = true;

        },
        openModal(index) {
            this.bookingId = index;

            if (!this.bookingData[index]) {
                this.bookingInfo = {
                    name:null,
                    phone:null,
                    seats:null,
                    time:null,
                };
            }
            else {
                this.bookingInfo = Object.assign({}, this.bookingData[index]);
            }
        },
        booking() {
            this.bookingData[this.bookingId] = Object.assign({}, this.bookingInfo);
            this.closeModal();
        },
        closeModal() {
            this.bookingId = null;
        }
    },


}).mount('#app');