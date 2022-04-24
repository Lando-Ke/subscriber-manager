import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useSubscribers() {
    const subscriber = ref([]);
    const subscribers = ref([]);

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
        console.log(data);
        errors.value = '';
        try {
            await axios.post('/api/subscribers', data);
            await router.push({ name: 'subscribers.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }

    };

    const updateSubscriber = async (id) => {
        errors.value = '';
        try {
            await axios.patch(`/api/subscribers/${id}`, subscriber.value);
            await router.push({ name: 'subscribers.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    };

    const destroySubscriber = async (id) => {
        await axios.delete('/api/subscribers/' + id)
    };

    return {
        errors,
        subscriber,
        subscribers,
        getSubscriber,
        getSubscribers,
        storeSubscriber,
        updateSubscriber,
        destroySubscriber
    }
}
