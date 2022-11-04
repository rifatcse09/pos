import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

const state = {
    user: null,
    orderList: [],
    orderInfo: "",
};

const store = new Vuex.Store({
    state,
    getters: {
        user: (state) => state.user,
        getOrders: (state) => state.orderList,
        getOrderInfo: (state) => state.orderInfo,
    },
    actions: {
        user: (context, user) => {
            context.commit("user", user);
        },
        getOrderList({ commit }) {
            return new Promise((resolve, reject) => {
                axios({
                    url: "orders",
                    method: "GET",
                }).then((res) => {
                    commit("set_orders", res.data.data);
                    resolve(res);
                });
            });
        },
        setOrderInfo({ commit }, id) {
            return commit("get_order", id);
        },
        setStatus({ commit }, { invoice, amount }) {
            console.log(amount);
            return new Promise((resolve, reject) => {
                axios({
                    url: `invoice/${invoice}/${amount}`,
                    method: "GET",
                }).then((res) => {
                    resolve(res);
                });
            });
        },
    },
    mutations: {
        user: (state, user) => {
            state.user = user;
        },
        set_orders(state, orders) {
            state.orderList = orders;
        },
        get_order(state, orderid) {
            let orderList = state.orderList.data;
            state.orderInfo = orderList.find((item) => {
                return item.id == orderid;
            });
            console.log(state.orderInfo);
        },
    },
    plugins: [createPersistedState()],
});

export default store;
