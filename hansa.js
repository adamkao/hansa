var i, gameid = 0, output = '', lines = [ '1', '2', '3', '4', '5' ], players = [];

function shuffle( array ) {
	var currentIndex = array.length, temporaryValue, randomIndex;
	while (0 !== currentIndex) {
		randomIndex = Math.floor( Math.random() * currentIndex );
		currentIndex -= 1;
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	}
	return array;
}

function toggleplay( id )
{
	var el = $( '#' + id );
	if (el.is( ':enabled' )) {
		el.prop( 'disabled', true );
	} else {
		el.prop( 'disabled', false );
	}
}

function togglewin( id )
{
}

function creategame( exp, players ) {
	$.post('api.php', {
		action: 'creategame',
		exp: exp,
		players: players
	}, function( data ) {
		obj = $.parseJSON( data );
		gameid = parseInt( obj[0] );
		$( '#gameid' ).val( parseInt( obj[0] ) );
		$( '#timestamp' ).val( ( obj[1] ) );
		$( '.play' ).prop( 'disabled', true );
		for (i = 1; i <= 5; i++) {
			if ($( '#play' + i ).is( ':checked' )) {
				$( '#win' + i ).prop( 'disabled', false );
			} else {
				$( '#' + i ).val( '' );
			}
		}
		$( '#creategame' ).prop( 'disabled', true );
		$( '#setwinners' ).prop( 'disabled', false );
	}).fail( function() {
		alert( "POST creategame failed." );
	});
}

function setwinners() {
	var i, output = '', winners = [];
	for (i = 1; i <= 5; i++) {
		if ($( '#win' + i ).is( ':checked' )) {
			winner = $( '#' + i ).val();
			winners.push( winner );
			output += winner + '\n';
		}
	}
	if (winners.length < 1) {
		alert( 'no winner' );
		return false;
	}
	$.post('api.php', {
		action: 'setwinners',
		gameid: gameid,
		winners: winners
	}, function( data ) {
		$( '#creategame' ).prop( 'disabled', false );
		$( '#setwinners' ).prop( 'disabled', true );
		$( '.win' ).prop( 'disabled', true );
		$( '.win' ).removeAttr( 'checked' );
		$( '.play' ).prop( 'disabled', false );
		$( '#output' ).val( data );
	}).fail( function() {
		alert( "POST setwinners failed." );
	});
}

function swiperight() {
	$( '#panner' ).animate( { right: '+=360' }, 100, function() {
	})
}
function swipeleft() {
	$( '#panner' ).animate( { right: '-=360' }, 100, function() {
	})
}

$( document ).ready( function() {
	var gameidlen = 0;
	$( '#creategame' ).click( function( e ) {
		gameid = 0;
		output = '';
		lines = [ '1', '2', '3', '4', '5' ];
		players = [];
		shuffle( lines );
		for (i = 0; i < lines.length; i++) {
			if ($( '#play' + lines[i] ).is( ':checked' )) {
				player = $( '#' + lines[i] ).val();
				players.push( player );
			}
		}
		if (players.length < 3) {
			alert( 'not enough players' );
			return false;
		}
		output = players.join( '\n' );
		$( '#output' ).val( output );
		for (i = lines.length; i < 5; i++) {
			players.push( 'NULL' );
		}
		exp = $( '#expansion' ).val();
		creategame( exp, players );
	} );
	$( '#gameid' ).on( 'keydown', function( event ) {
		if ((event.which > 47) && (event.which < 58)) {
			if (gameidlen < 3) {
				gameidlen++;
			} else {
				event.preventDefault();			
			}
		} else if ((event.which == 10) || (event.which == 13)) {
			// enter key
		} else if (event.which == 8) {
			gameidlen--;
		} else {
			event.preventDefault();			
		}
	} );
	$( '#statsplayer' ).on( 'keydown', function( event ) {
		if ((event.which == 10) || (event.which == 13)) {
	$.get('api.php', {
		action: 'getstats',
		player: $( '#statsplayer' ).val()
	}, function( data ) {
		$( '#routput' ).val( data );
	}).fail( function() {
		alert( "GET stats failed." );
	});
		}
	} );
} );
