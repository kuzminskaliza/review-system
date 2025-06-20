import {ref} from 'vue';

export default {
    emits: ['submitted'],

    setup(_, {emit}) {
        const apiBase = 'http://api.review-system.local/api/review';

        const authorName = ref('');
        const text = ref('');
        const sending = ref(false);
        const message = ref('');
        const error = ref(false);

        const submitReview = async () => {
            if (!authorName.value.trim() || !text.value.trim()) {
                message.value = 'Будь ласка, заповніть всі поля';
                error.value = true;
                return;
            }

            sending.value = true;
            message.value = '';
            error.value = false;

            try {
                await window.axios.post(apiBase, {
                    author_name: authorName.value,
                    text: text.value,
                });

                message.value = 'Дякуємо! Відгук відправлено на модерацію.';
                error.value = false;

                authorName.value = '';
                text.value = '';

                emit('submitted');
            } catch (err) {
                message.value = 'Помилка при відправці відгуку.';
                error.value = true;
                console.error(err);
            } finally {
                sending.value = false;
            }
        };

        return {
            authorName,
            text,
            sending,
            message,
            error,
            submitReview,
        };
    },

    template: `
    <form @submit.prevent="submitReview" class="review-form">
      <input
        type="text"
        v-model="authorName"
        placeholder="Ім'я"
        :disabled="sending"
      />

      <textarea
        v-model="text"
        placeholder="Текст відгуку"
        rows="4"
        :disabled="sending"
      ></textarea>

      <button
        type="submit"
        :disabled="sending"
      >
        {{ sending ? 'Відправка...' : 'Відправити' }}
      </button>

      <p v-if="message" :class="error ? 'error-message' : 'success-message'">
        {{ message }}
      </p>
    </form>

  `
};
