import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useSubscribers() {
    const subscriber = ref([]);
    const subscribers = ref([]);
    const states = ref([]);

    const errors = ref('');
    const router = useRouter();

    const getSubscribers = async () => {
        let response = await axios.get('/api/subscribers');
        subscribers.value = response.data.subscribers.data
    };

    const getSubscriber = async (id) => {
        let response = await axios.get(`/api/subscribers/${id}`);
        subscriber.value = response.data.subscriber
    };

    const storeSubscriber = async (data) => {
        errors.value = '';
        try {
            await axios.post('/api/subscribers', data);
            await router.push({ name: 'subscribers.index' })
        } catch (e) {
            if (e.response.status === 422) {
                    errors.value += e.response.data.errors;
            }
        }

    };

    const updateSubscriber = async (id) => {
        errors.value = '';
        //TODO: Implementing updating of fields. This will take some time.
        delete subscriber.value.fields;
        try {
            await axios.patch(`/api/subscribers/${id}`, subscriber.value);
            await router.push({ name: 'subscribers.index' })
        } catch (e) {
            if (e.response.status === 422) {
                    errors.value += e.response.data.errors;
            }
        }
    };

    const destroySubscriber = async (id) => {
        await axios.delete('/api/subscribers/' + id)
    };

    const getStates = async () => {
        let response = await axios.get('/api/states');
        states.value = response.data.states
    };

    return {
        errors,
        subscriber,
        subscribers,
        getSubscriber,
        getSubscribers,
        storeSubscriber,
        updateSubscriber,
        destroySubscriber,
        getStates
    }
}
