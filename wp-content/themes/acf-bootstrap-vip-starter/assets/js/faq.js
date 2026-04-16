document.addEventListener('DOMContentLoaded', function () {

	const questions = document.querySelectorAll('.faq-question');

	questions.forEach(btn => {

		btn.addEventListener('click', function () {

			const expanded = this.getAttribute('aria-expanded') === 'true';
			const answer = document.getElementById(this.getAttribute('aria-controls'));

			// Close all (optional - accordion mode)
			document.querySelectorAll('.faq-question').forEach(q => {
				q.setAttribute('aria-expanded', 'false');
			});

			document.querySelectorAll('.faq-answer').forEach(a => {
				a.hidden = true;
			});

			// Toggle current
			if (!expanded) {
				this.setAttribute('aria-expanded', 'true');
				answer.hidden = false;
			}

		});

	});

});