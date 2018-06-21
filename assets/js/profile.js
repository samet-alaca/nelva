var chart = document.getElementById("discordChart");
var ctx = (chart !== null) ? chart.getContext("2d") : null;

$('#discord-chart-type').unbind().change(function() {
	reset_canvas();
	load_discord();
});

var start = moment().subtract(6, 'days');
var end = moment();

function cb(start, end) {
	$('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));

	reset_canvas();
	var s = new Date(start);
	var e = new Date(end);

	s = addZero(s.getDate() + '') + '/' + addZero((s.getMonth() + 1) + '') + '/' +  s.getFullYear();
	e = addZero(e.getDate() + '') + '/' + addZero((e.getMonth() + 1) + '') + '/' +  e.getFullYear();
	load_discord(s, e);
}

$('#reportrange').daterangepicker({
	startDate: start,
	endDate: end,
	locale: {
		format: 'DD/MM/YYYY'
	},
	ranges: {
		"Aujourd'hui": [moment(), moment()],
		'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'7 derniers jours': [moment().subtract(6, 'days'), moment()],
		'30 derniers jours': [moment().subtract(29, 'days'), moment()],
		'Ce mois': [moment().startOf('month'), moment().endOf('month')],
		'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		'Cette année': [moment().startOf('year'), moment().endOf('year')],
		"L'année dernière": [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
	}
}, cb);

cb(start, end);

function addZero(d) {
	if(d.length == 1) {
		return '0' + d;
	}
	return d;
}

function reset_canvas() {
	$('#chart-container').html('');
	$('#chart-container').append('<canvas id="discordChart" height="200"><canvas>');
	chart = document.getElementById("discordChart");
	ctx = (chart !== null) ? chart.getContext("2d") : null;
}

function load_discord(s = null, e = null) {
	if(ctx === null) { return; }
	ctx.clearRect(0, 0, ctx.width, ctx.height);

	var period = $('#period').html();

	if(s && e) {
		period = s + ' - ' + e;
	}
	$.post(location.href, { period: period }).done(function(discordData) {
		var discord = JSON.parse(discordData);
		if(discord !== null) {
			var d = {
				labels: [],
				datasets: [{
					label: 'Nombre de messages',
					data: [],
					lineTension: 0.1,
					backgroundColor: "rgba(58,93,174,0.8)",
					borderDash: [],
					borderDashOffset: 0.0,
					borderJoinStyle: 'miter',
					pointBorderColor: "rgba(75,192,192,1)",
					pointBackgroundColor: "#fff",
					pointBorderWidth: 1,
					pointHoverRadius: 5,
					pointHoverBackgroundColor: "rgba(75,192,192,1)",
					pointHoverBorderColor: "rgba(220,220,220,1)",
					pointHoverBorderWidth: 2,
					pointRadius: 1,
					pointHitRadius: 10,
				}]
			};
			for(var i = 0; i < discord.length; i++) {
				d.labels.push(discord[i].date);
				d.datasets[0].data.push(discord[i].m_count);
			}
			var lineChart = new Chart(ctx, {
				type: $('#discord-chart-type').val(),
				data: d,
				options: {
					title: {
						display: true,
						text: 'Statistiques Discord via Nelvabot'
					},
					legend: {
						display: false
					},
					animation: {
						easing: 'easeOutElastic'
					}
				}
			});
		}
	});
}
