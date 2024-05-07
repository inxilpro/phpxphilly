import Alpine from 'alpinejs';
import Typed from 'typed.js';

window.Alpine = Alpine;

Alpine.directive('typed', (el, { expression, modifiers }, { evaluateLater, effect, cleanup }) => {
	const getStrings = evaluateLater(expression);
	
	const modifierValue = (key, fallback) => {
		if (-1 === modifiers.indexOf(key)) {
			return fallback;
		}
		
		const value = modifiers[modifiers.indexOf(key) + 1];
		
		if (value && ! isNaN(fallback)) {
			return parseInt(value);
		}
		
		return value ? value : fallback;
	}
	
	effect(() => getStrings(strings => {
		const instance = new Typed(el, {
			strings,
			startDelay: modifierValue('delay', 750),
			typeSpeed: modifierValue('speed',150),
			backSpeed: modifierValue('backspace', 100),
			showCursor: ! modifiers.includes('cursorless'),
			loop: modifiers.includes('loop'),
			cursorChar: '_',
		});
		cleanup(() => instance.destroy());
	}));
});

Alpine.start();
