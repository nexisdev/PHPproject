// const SECONDS = 1000;
const MINUTES = 60;
const HOURS = 60 * MINUTES;
const DAYS = 24 * HOURS;
// const WEEKS = 7 * DAYS;
const MONTHS = 30 * DAYS;

export default (expiry) => ({
    expiry: expiry,
    remaining: null,
    init() {
        this.setRemaining();
        setInterval(() => {
            this.setRemaining();
        }, 1000);
    },
    setRemaining() {
        const diff = this.expiry - new Date().getTime();
        this.remaining = isNaN(diff) ? 0 : parseInt(diff / 1000);
    },
    months() {
        return {
            value: this.remaining / MONTHS,
            remaining: this.remaining % MONTHS,
        };
    },
    days() {
        return {
            value: this.remaining / DAYS,
            remaining: this.remaining % DAYS,
        };
    },
    hours() {
        return {
            value: this.days().remaining / HOURS,
            remaining: this.days().remaining % HOURS,
        };
    },
    minutes() {
        return {
            value: this.hours().remaining / MINUTES,
            remaining: this.hours().remaining % MINUTES,
        };
    },
    seconds() {
        return {
            value: this.minutes().remaining,
        };
    },
    format(value) {
        return ("0" + parseInt(value)).slice(-2);
    },
    time() {
        return {
            months: this.format(this.months().value),
            days: this.format(this.days().value),
            hours: this.format(this.hours().value),
            minutes: this.format(this.minutes().value),
            seconds: this.format(this.seconds().value),
        };
    },
});
