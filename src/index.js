import 'vite/modulepreload-polyfill';
import './style.scss';

// Slider - Library import example
// import { tns } from "tiny-slider"

document.addEventListener('DOMContentLoaded', () => {
	// Lazy load fade in
	document.querySelectorAll( 'img[loading="lazy"]' ).forEach( ( img ) => {
		if( img.complete === true ) {
			img.classList.add( 'has-loaded' );
		}
		img.addEventListener( "load", ( e ) => {
			e.target.classList.add( 'has-loaded' );
		} );
	} );

	// Copyright Year
	document.querySelectorAll(".copyright").forEach( ( p ) => { 
		p.innerHTML = p.innerHTML.replace( '{YEAR}', new Date().getUTCFullYear() );
	} );

	// Search 
	document.querySelector( ".search-wrapper .wp-block-button .wp-block-button__link" )?.addEventListener( "click", e => {
		e.preventDefault();
		document.body.classList.toggle( "show-search" );
	} );

	document.body.addEventListener( "click", e => {
		if( e.target.closest( ".search-wrapper" ) === null && document.body.classList.contains( "show-search" ) ) {
			document.body.classList.remove( "show-search" );
		}
		console.log( e.target.closest( ".signup-form-inner" ) );
		console.log( e.target.closest( ".signup-buttons") );
		if( ( e.target.closest( ".signup-form-inner" ) === null && e.target.closest( ".signup-buttons") === null ) && document.body.classList.contains( "show-signup" ) ) {
			document.body.classList.remove( "show-signup" );
		}
	} );

	document.querySelector( ".close-signup" )?.addEventListener( "click", e => {
		e.preventDefault();
		document.body.classList.toggle( "show-signup" );
	} );

	document.querySelectorAll( "a[href*=\"#sign-up\"]" ).forEach( link => {
		link.addEventListener( "click", e => {
			e.preventDefault();
			document.body.classList.toggle( "show-signup" );
		} );
	} );

	document.addEventListener('keydown', e => {
		if ( e.key === 'Escape' ) {
			document.body.classList.remove( "show-search" );
			document.body.classList.remove( "show-signup" );
		}
	});
});