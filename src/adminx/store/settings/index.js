import { createReduxStore, register } from '@wordpress/data';

const store = createReduxStore('ultimate-store-kit/settings', {
    reducer: (state = {}, action) => {
        return state;
    },
});

register(store);
