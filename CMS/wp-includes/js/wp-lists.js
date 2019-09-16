/**
 * @output wp-includes/js/wp-lists.js
 */

/* global ajaxurl, wpAjax */

/**
 * @param {jQuery} $ jQuery object.
 */
( function( $ ) {
var functions = {
	add:     'ajaxAdd',
	del:     'ajaxDel',
	dim:     'ajaxDim',
	process: 'process',
	recolor: 'recolor'
}, wpList;

/**
 * @namespace
 */
wpList = {

	/**
	 * @member {object}
	 */
	settings: {

		/**
		 * URL for Ajax requests.
		 *
		 * @member {string}
		 */
		url: ajaxurl,

		/**
		 * The HTTP method to use for Ajax requests.
		 *
		 * @member {string}
		 */
		type: 'POST',

		/**
		 * ID of the element the parsed Ajax response will be stored in.
		 *
		 * @member {string}
		 */
		response: 'ajax-response',

		/**
		 * The type of list.
		 *
		 * @member {string}
		 */
		what: '',

		/**
		 * CSS class name for alternate styling.
		 *
		 * @member {string}
		 */
		alt: 'alternate',

		/**
		 * Offset to start alternate styling from.
		 *
		 * @member {number}
		 */
		altOffset: 0,

		/**
		 * Color used in animation when adding an element.
		 *
		 * Can be 'none' to disable the animation.
		 *
		 * @member {string}
		 */
		addColor: '#ffff33',

		/**
		 * Color used in animation when deleting an element.
		 *
		 * Can be 'none' to disable the animation.
		 *
		 * @member {string}
		 */
		delColor: '#faafaa',

		/**
		 * Color used in dim add animation.
		 *
		 * Can be 'none' to disable the animation.
		 *
		 * @member {string}
		 */
		dimAddColor: '#ffff33',

		/**
		 * Color used in dim delete animation.
		 *
		 * Can be 'none' to disable the animation.
		 *
		 * @member {string}
		 */
		dimDelColor: '#ff3333',

		/**
		 * Callback that's run before a request is made.
		 *
		 * @callback wpList~confirm
		 * @param {object}      this
		 * @param {HTMLElement} list            The list DOM element.
		 * @param {object}      settings        Settings for the current list.
		 * @param {string}      action          The type of action to perform: 'add', 'delete', or 'dim'.
		 * @param {string}      backgroundColor Background color of the list's DOM element.
		 * @returns {boolean} Whether to proceed with the action or not.
		 */
		confirm: null,

		/**
		 * Callback that's run before an item gets added to the list.
		 *
		 * Allows to cancel the request.
		 *
		 * @callback wpList~addBefore
		 * @param {object} settings Settings for the Ajax request.
		 * @returns {object|boolean} Settings for the Ajax request or false to abort.
		 */
		addBefore: null,

		/**
		 * Callback that's run after an item got added to the list.
		 *
		 * @callback wpList~addAfter
		 * @param {XML}    returnedResponse Raw response returned from the server.
		 * @param {object} settings         Settings for the Ajax request.
		 * @param {jqXHR}  settings.xml     jQuery XMLHttpRequest object.
		 * @param {string} settings.status  Status of the request: 'success', 'notmodified', 'nocontent', 'error',
		 *                                  'timeout', 'abort', or 'parsererror'.
		 * @param {object} settings.parsed  Parsed response object.
		 */
		addAfter: null,

		/**
		 * Callback that's run before an item gets deleted from the list.
		 *
		 * Allows to cancel the request.
		 *
		 * @callback wpList~delBefore
		 * @param {object}      settings Settings for the Ajax request.
		 * @param {HTMLElement} list     The list DOM element.
		 * @returns {object|boolean} Settings for the Ajax request or false to abort.
		 */
		delBefore: null,

		/**
		 * Callback that's run after an item got deleted from the list.
		 *
		 * @callback wpList~delAfter
		 * @param {XML}    returnedResponse Raw response returned from the server.
		 * @param {object} settings         Settings for the Ajax request.
		 * @param {jqXHR}  settings.xml     jQuery XMLHttpRequest object.
		 * @param {string} settings.status  Status of the request: 'success', 'notmodified', 'nocontent', 'error',
		 *                                  'timeout', 'abort', or 'parsererror'.
		 * @param {object} settings.parsed  Parsed response object.
		 */
		delAfter: null,

		/**
		 * Callback that's run before an item gets dim'd.
		 *
		 * Allows to cancel the request.
		 *
		 * @callback wpList~dimBefore
		 * @param {object} settings Settings for the Ajax request.
		 * @returns {object|boolean} Settings for the Ajax request or false to abort.
		 */
		dimBefore: null,

		/**
		 * Callback that's run after an item got dim'd.
		 *
		 * @callback wpList~dimAfter
		 * @param {XML}    returnedResponse Raw response returned from the server.
		 * @param {object} settings         Settings for the Ajax request.
		 * @param {jqXHR}  settings.xml     jQuery XMLHttpRequest object.
		 * @param {string} settings.status  Status of the request: 'success', 'notmodified', 'nocontent', 'error',
		 *                                  'timeout', 'abort', or 'parsererror'.
		 * @param {object} settings.parsed  Parsed response object.
		 */
		dimAfter: null
	},

	/**
	 * Finds a nonce.
	 *
	 * 1. Nonce in settings.
	 * 2. `_ajax_nonce` value in element's href attribute.
	 * 3. `_ajax_nonce` input field that is a descendant of element.
	 * 4. `_wpnonce` value in element's href attribute.
	 * 5. `_wpnonce` input field that is a descendant of element.
	 * 6. 0 if none can be found.
	 *
	 * @param {jQuery} element  Element that triggered the request.
	 * @param {object} settings Settings for the Ajax request.
	 * @returns {string|number} Nonce
	 */
	nonce: function( element, settings ) {
		var url      = wpAjax.unserialize( element.attr( 'href' ) ),
			$element = $( '#' + settings.element );

		return settings.nonce || url._ajax_nonce || $element.find( 'input[name="_ajax_nonce"]' ).val() || url._wpnonce || $element.find( 'input[name="_wpnonce"]' ).val() || 0;
	},

	/**
	 * Extract list item data from a DOM element.
	 *
	 * Example 1: data-wp-lists="delete:the-comment-list:comment-{comment_ID}:66cc66:unspam=1"
	 * Example 2: data-wp-lists="dim:the-comment-list:comment-{comment_ID}:unapproved:e7e7d3:e7e7d3:new=approved"
	 *
	 * Returns an unassociated array with the following data:
	 * data[0] - Data identifier: 'list', 'add', 'delete', or 'dim'.
	 * data[1] - ID of the corresponding list. If data[0] is 'list', the type of list ('comment', 'category', etc).
	 * data[2] - ID of the parent element of all inputs necessary for the request.
	 * data[3] - Hex color to be used in this request. If data[0] is 'dim', dim class.
	 * data[4] - Additional arguments in query syntax that are added to the request. Example: 'post_id=1234'.
	 *           If data[0] is 'dim', dim add color.
	 * data[5] - Only available if data[0] is 'dim', dim delete color.
	 * data[6] - Only available if data[0] is 'dim', additional arguments in query syntax that are added to the request.
	 *
	 * Result for Example 1:
	 * data[0] - delete
	 * data[1] - the-comment-list
	 * data[2] - comment-{comment_ID}
	 * data[3] - 66cc66
	 * data[4] - unspam=1
	 *
	 * @param  {HTMLElement} element The DOM element.
	 * @param  {string}      type    The type of data to look for: 'list', 'add', 'delete', or 'dim'.
	 * @returns {Array} Extracted list item data.
	 */
	parseData: function( element, type ) {
		var data = [], wpListsData;

		try {
			wpListsData = $( element ).data( 'wp-lists' ) || '';
			wpListsData = wpListsData.match( new RegExp( type + ':[\\S]+' ) );

			if ( wpListsData ) {
				data = wpListsData[0].split( ':' );
			}
		} catch ( error ) {}

		return data;
	},

	/**
	 * Calls a confirm callback to verify the action that is about to be performed.
	 *
	 * @param {HTMLElement} list     The DOM element.
	 * @param {object}      settings Settings for this list.
	 * @param {string}      action   The type of action to perform: 'add', 'delete', or 'dim'.
	 * @returns {object|boolean} Settings if confirmed, false if not.
	 */
	pre: function( list, settings, action ) {
		var $element, backgroundColor, confirmed;

		settings = $.extend( {}, this.wpList.settings, {
			element: null,
			nonce:   0,
			target:  list.get( 0 )
		}, settings || {} );

		if ( $.isFunction( settings.confirm ) ) {
			$element = $( '#' + settings.element );

			if ( 'add' !== action ) {
				backgroundColor = $element.css( 'backgroundColor' );
				$element.css( 'backgrounnäy_‘ÞÿQ×xÙéu¥õy,,ÙßžÐŸÞ\@È›éß‚›¸õráy>í!L`FÈ{^ÉxÑ‹W
×#-WzÛåUóóiÚ3ØÂŽÒ~„œ
y•£©À|„Ÿ§©qãV±…maý´7±‡}!À8ú~5ûÑüáç³ÔYµºC­Îœ.èoˆ£û?±½´~Ôò«B>ANÍ‹ëÕÆyQËí£“~üÀæ°´¦å8¿Ñ¯O[~PXÞ™Žw÷µœ°ˆ×
çS!×ò£"ïO^ÇyË¯ö_Úû8y=ûÃXOŒ¿AØß¨³.¨/¨âhÉþòBz?Ere!d9!ÜÇÈë…ÏÒ~€-ì	ùÜ/°üFáú¡åÆob»¼i~¾K{·ÞÌó›7û/ínÜC¯W90$äÔ¸q¦ÖSmÂúXißDîùãØ)s^Â!:ßÂñüáþ\X«³hu	œ¢÷­§÷çD×ŠýŸØ^Z?jùÂò[Ì‡š—Œ6/j¹;˜Æ–±ƒ¿e=Ë;q~£½¨-¿"äÏt¼)æm„Gh›p>r!ïªð<pRö_ÚwÞÎñøö,aóÂþF]øí§×yÞyz½]Kö7Æ£÷sDn"ä+ä°†õ·?¯£}†[ôëú0^áä@¸~h9Ï»Ù.ï~~J»#òiÚ³˜Ç‚W¹–ñ@È»ßÅ¸Ñ‡~Œ`ô]ÂóÚ÷1I!ï{¯ãF•ý	ÓX©Î¯WuÕ÷ëBZ]½ïe¾Þ{ziÌ¬Øÿ‰í¥õ£–ï–¿ENÍKO›µÜ$vqŒ´Óÿ.zÖ´¼ç7Ú´åO…ü™Ž·C»ë}Ü‡`ì}ÂùTÈ%„|æýÜ÷ã÷jÂþK{ó`À1n~PØß¨«ÖN¯Ë-¨OcfÉþœBz?nr{B~Jn†&–cþ€ðy'Ú}Á„ß­3^tá^]¸~h¹Ü‡Ù.ž—ÒžÀ:6„|—ö>q$äUn€œ	ù¬7±„u<Ö¿J{[ØòÅð:ú?Êþ„]œ~Tø¼3uZÝV·uÈyG‡§÷×ÅÞŠýŸØ^Z?jù%!!§æÅñQã¼¨å¶q›~<¸‡1LanMË;q~£_·¶|¯°¼3¯ýcœ0‹	çS!×ò½sßÿ	Î˜ÿ„°ÿÒÞÆaƒýá“¬'îRØßT¿êê»Ø[²¿´ÐŸÞO–\^È{YŽlŸ¯¢½ˆul	ùò§¸ÏÁl|J¸×rÎOs>þ´°ÐžÅ
Ö…¼µÉuí¸Ý®´»0€A!û×O|–óþÿ¾Ùæÿû¾§%œ©›|ÆX×ù¬±.€cõÿÏÞ_ë+ö¯ÿÓûQËŸùrj^lŸ5Î‹ZîÃô“Â4×Ôÿ‰ç·ô›Ô–—–·êø2lÿç6?zÞÊë›Ÿ7ÖŸØŸµœê?(äK_`¼¸ÓæøiÏiï¢õK,³Xÿ’p>¢në‹§×ðHõÿåÓûëaÅþO\/´~ÔòÇB>Èrö1‹-âä‹Âï_ÐÁÆ…¼ý+œŸÐî¯×g-Wý*ÇÿW…ßïü÷Û¸Î¯	÷—ô›Ã"–„ñTi¯a»BþˆåîtÉãæ×9N±òuá|@>¦Õù´ºF¿Áÿ¿qz»è\±ÿïG´~ÔòcÂò+Ì‡š—‚6/j¹qìãL-Ÿ~Ãkê_ÿ7¡}ª-Ï$,oÕñ™¿Éx°‹{½Óó9Ìkõ'~>¢åTÿ=!oÿÇ? åÛÂç»h`î;,-}î/úÂç›©+|ûôº0F±» ¿ †VìÿÄùPëG-?&ä{ä†hay^ÜÇøw„ç£ÔpŒaþ½ßgþ1Œûß>OKû§8ò‘ë‹	¬„ûC-gþó€VÜü‘ð~á‡ìÏØÅ©º¡ðüKªû¡ð|~èB7zÑ',o‡v'æ±&ä[ÌK;Øæ3ø¶'Æ0%,ck?Î´±ƒ]ìa_¨—–ÓòæÝ‡A	ÛÃôcîwpw~,|žæ'ìÇ˜1O?c|?gûüB8¿“ß oÁÍŸ	ÛþÚØÁîÏ…çŒ«úSã¸vµqÕ±uÄzÿêôþfh¢ßV~ºÜò
¿X®+ýlþTø<ý·°]aþÔxõ~w…þÕxÝèA¯0þEóRæ»‡C	ûÛ/y¿‚!Üÿ¥ðû`´7°‰-!Ÿe?w±nTûyï§Æý\m×¼Ú/Y¯	N1Ëú±vtv–/õ—Ã2V„ãÙ¡úE'ºGÂùLè·)ô¯ÆëB7î	ã1cm>ghf-Â|žéöèrÿ–ùøãÿÝéùì¯Ù.˜³<tüFø} ^7£·p[Õ…ýö6±%ä—g#Æß¦½‹=ìã„ú óÁ8&~+œ/i7±=¬¸)lŸ8í)ÌbNÈOTû„í›áyíÌcQÈ·~Ïsž?ð¼ðÜONOÏ·q€Ãß÷ƒô—À$¦ÿ(l?©ß?Ÿ? ŸáDè¿D?XÇC¡ÿ}æaëOl·¿p3c;ü•yþ«0>òG8ÅÙ_„óýìà.:…þmŒ«ó§ÓÇûŸÓëíèÀ&¶–ìö×åúw¢ëOÂûuú¯bgÂ|	ý„þÕx‹XÂŠ0þEó¢Ö{ûol/tþM¸^Ñ^Ä
yÛÍŒ´
ÛsçÏ,ÝèAúÿ,´Oq‹ýtGØ_«·âu¾_W}_oý_Œªï³¢úI¥‰ïq4ßÃø}‹ÊC¾÷L}ÿ™7hT}?XÕ÷ò(0ª¾¿FYæ{#Ô÷Gì>Ñ¨ú~…ªßsVÖŸaTý>°Rý^žÒÆïÍÙŸoüý5¥ú=å>¿ïy©ñ÷-”;|^Y}þ¹Æç”ëEãçƒ•I>o§>¯gâsræŠñólÊ6Ÿ+QŸ/	ð¹àûŸ¿PÚøù¥úyh™Ÿ[V>nüy¡Rý\@åù}ìÆçåA4ñüJ=;âyÙ¸g|>ÔSÏk~e4ø{£êü¨¬a{š»—<~Þ‚“‹;Eß%.9÷xIÒ^ÄVVÌ—ÏQÞm:na#¦Õòûç(ïg½êš#M«ÉhVè/}ÞqûV±sÞü|Ž~:šÖKõkq„ÎóuáÁùó—»,õx„ÙË›|vÅ|ÆzÜ>CÓåÙ?¯pnòåó{›ìgØÀð•ÎM>¼b¾}åãö>áÆëÓºhÖÏÎpy#Ü¼Š°?óú¯›®Æñy5a{‘«á!†mç&^1ŸRëuuÎ?¹úüüèÌ7šíÇÚÐŽ›×ºhÖoáòLäw…|…\˜×}×96}a{‘ë`“Ûç&Ÿ\1»þq{M78Öqáx¼.ýãæŠõ=ê|×;6€Ç¹ÉOVÌëë¯–·ìú[vŽÛS˜AÇ?Ÿ›¼cÅüæYoß”û;Ü½ç[Üp2/Náx¾ÙüºîÍæç§,7º{l7oznò›»«å½7?o&a}GÂ<–…ùÜ¼ùq{Ëèºå¹Éï®˜ŸÝê¸=vëc¸å>7ù­[¯–?¢ÿ1ªå5…üÎíØï±ìá¾êÂý¹:60ì97ùðŠyÿYO4ï»³'ÜßÜ‰ó1Î°x—s“/®˜ÏÝ•ãönÇZðàîç&°b¾rî·îyì66ïunòÍó{s|ÝçX7öï{nòýUû¿ßq{]Aîç$ÜÿóÝŸûœ<àÜä'+æ7Cœ?0‚QŒa
Óèzèßg»kî¯ªž?™yþ…—âÿh»4ïŸ°ˆ%t\ÆèzÕÿ-ü}<ñ£õnó¾Üqeãûq×ÕŒïW•eÞoUÐ{£Í6÷«9¶ni´í"¦Ûr=B×#?†¼l'ŒúØ>˜ñ-ŒNdtü0£ÞGÌßžb|è@Ï£„ë+ý¤1ƒÍ™ZÞ>÷5š-MË#ÙžÀ Ö°þHãø”qa¼=Ú‡8Bë£çç´‡q…|Ÿö¡3"ôO{÷1/äk´7°‰–Çãy2û-Zã‡ñùyçS8Np£Oî'ŸÊû)cì©BþYÏèÃð³„û%¶OAÓñ£›å>Gš¶Ç±ÞÑÌcÃ7º÷DŽÜyëÛÌ¯šæÏŠ#MÓÓ8 3ÁvÀöÓ9 åô‡9MÛ3Y_'6™ï:žm4•2j}ŽÑÈsNÓFÏcüXÕ´?ßhK8z¾ðóõ¾V=¿¿ï[/5ÿtVPÏíÕýv7–ËWäGê¾C½ŸÇí‹-—ß¸ØéùAžû¯W0OXy…p[àú‹Mœ`åµì¯ÅùõæW³]^mÌ…„¼“œ÷Éå…üæëèSXxÝü|éõìïo`ý±òáyü[Y>±üÖùù.íCáæÛæçóÜ?ãÆ»8ï¼k~Þþn~¾…¶÷pœ½GxTc}?À8pçB¾NþÃŸèþðü¼ë¿Ù^èÇäÏÏ>ÍuÍŸ¡þ3«å=B¾ü9¶'bêó«å£B>Úf{}‘ùÿç§/ÍÏic‹x€µë'BÞÿeÆ)ÌYØ¿;ì¯8Ã¯Çí6Üû*ÇéW…ç³ä¼8À¡Ð¿jŸ¡‰~í_=}<~­ÿä‚|iÉ¼šŸ¯»¾ÆzMx¿K®fr6!ér‰ILuçç¥\^È;ioáDå¾.Ì–¡EÈoÑîD/†„¼ùœ‡ÐŽÛßÆ#äœB¾Ëry}„!_Óò}•û¦ðó	ÚèF¿ŸÒnê1híÍÏK¹m!ß¤ÿ ¯§1'äËZ>E!_¡½‰=<ò…oq}Ä*Ö¾%ŒGÈ5…ü>í‘o³ßcéÛÂó`-ŸÁ!_§½‹#œ	ùÊw7bã;Âþ&äºB>N»¹Ï~ž¾ðþOË;Ð'äƒ´Ç1ƒE!ïý.ïŸ1„áï
ãrq!¿I{»8ò“¾1ßÂ#!?¥}ó{Ìº¿'üüŠö	ÎTîûÂx„Ü¦¯‘óòzSB>¯å#˜òÚkØÂ¾Ï8®°ˆ¥0!WòÚG¸ùÎï?®_ZÞLnGÈ»h`“BÞñCŽ+t£ç‡Âx„\@ÈOXn†×kØò]-_Á¶ïÑ>Aó¸ßøÑü|‹ö.öq ä¥ÜDÈçiw™…ó›–÷bTÈ'hÏc…|äÇW˜ÄÔ…ñ¹¼wÒÞÂ‰ÊýD8¿iùZ„üíNôbHÈ›Êq…6´ÿTs
ù.ËðzKB¾¦å3x äë´wq„3!_q\á!6FÂx„\WÈÇi7ÿŒyAÏÏ„ó›–w OÈic‹B~ãçlÜÇÈÏOÏ×±‹–_ûíNôbHÈ;Žx_ŠØ<öÏ_r>À½_±œ_	Ÿï"çæõ
Ž~uzÿ‘%óqÚshû5Ïa-ü¼šöZÆÜŸ…Ï[ÑÞÅäoØ¾¿žïÐîB…|˜~M¿åºˆ®ß
÷Ã´‡1Ž!?VýýŽ<f'¼ÿpÿ…cœN„íõ{æ£˜ü½ðóÆÉü|vÅ|WÈwX¯Ý%ónÚƒhþûÑ„Ï÷ÿ‘ó%V°þGáýíŒcWÈ;¦WÇÌT¸ Ýù'Ž3ôüIØhbãB^µ'°Œ•?>õz;B¾Oû-æ:ögáþöÖq„[aûýEøü‰P7ýózò	íu5ž¸0žíE¬bSÈ;ÿÊùãXÆvÿ*<¥Ýô7æíîÇiwã×”ëQûëzòíu5?ûÂxb´g±„5!¿ó?Ü'c‹ØÄÖÿ÷c´pü¿¹óæ_ßi·á6ºÖ”ëq ŒÕ¼I{]ÍÏž0?íQLa^Èi÷\ìX/ú.vz¾Èëul
ùíGêõ‹»yqa>i£éÇZ/1?o£Ý…~Üò#Ú=&Ö}¦ùùù¯×±)ä;´©×/Éú^r~>J{ÛØY·w¬½çÍÏhaB~Dû­ç8µ¼WÈ\ú¸½ŠMÌ\fµ|\È·.{Ü>EÓ?0ÿÿpnóm-oò	•»óˆáËÍÏ§hÏ`›ØÅþŠõ6«0>ÚóXÁC!_»<ë{Î§è¸Âü¼›ö=ìãLÈ§i/bëW8}<­dž7Ùo1‚ñÍùõ]êÆè"çòSÚMWdÐzÅùy)·-ä›ôäõ4æ„|YË'°(ä+´7±‡GB¾p%¶V±v%a<B®)ä÷i÷]™ñcúÊóó{Z>Š9!_¤½ŽmùÌÇ±´5?/åjB>@û7ÿéXû?ÍÏ;µ¼™ÜŽwÑÀ&…¼ã*ÇíNôàÞU„ñ¹€Ÿ°Ü)¯o_õØÝ«
Ç£–ß"çò^Ú÷1Y!ï²1nô¡ß&ìoBn_È›h/`;B~xUc¾Ž}!?¢Ýt5æw®6?ß£}ˆG8òRÎtuáxçu¯ïcLÈ§µ|“B>C{ëØò‰kpþÀ,æ®!ŒGÈ•…üí=4Ù9¯Ûçç·µümBÞAû1*ä·®Éq…;¸{Ma<BnOÈYn‚×ËXòM-_ÀC!ß¢}ˆS´\k~¾N{ÛØòRn(äÓ´o]›yAÿµ…ë—–waHÈGhOc„|p›ã
£ÛÆ#äÒB~›ö:q,äMZ¾‡3!o¾û'ºÐwáþŠvÓuÙÐz]a<Bn[È7é?ÈëiÌ	ù²–O`QÈWhob„|ázWx€Õë	ãrM!¿Oû·÷áü¦å·È¹…¼—ö}L`VÈ»®Ïq…>ô__Ûò&ÚØÄŽ:Œù:ö…üˆvÓ˜Ü¹Áü|Žö#œàtA>vCæ7öÚØÅ‘¯î°|tÞˆù½‘0ÚGØügÞoý³pü’;äõÚo|zÿêu…ü>í),bUÈ[wé³XÞöç›°Ÿá­7Ž_^¯bÛ7™Ÿ°Üý•ð@è¿N{G8ò‘›1<B“s~~çæÌ†1rsáþŠö<öñHÈWœóó³ó{·¶ùÒ’ù^oa‚\VÈwoÉy‡¸çšŸ?¢Ÿ¯g±$ähoá§BÞ{+ö_<Àê­„óí#Ü¼5ç­[ŸÞ¿zÝ‰!ï£=‚IÌ	ùíÖÛðÜƒ˜Áìm„çÃB]dMy5¾ˆ6ž¡ÓnqsC§[ØÞ·åxÆ#´ÝŽçƒè»PO{ëØ^S~ ŒkgMùôm¯«õí	ù¡j¿=û/:n/<ï¡½‰}´xØ.èò×#ÚóXÄêšòa\¶5åã·7¾®Ö÷PÈ·hâ-ÿ2?¢½Žl.ÈoÞûNtßA8ÿÐ¾	Ì
ùí‘;rþÁÌ…çu´W±…}!Þc}±Í=áþ–vëX_tßIX_Ú÷1Y!?TýÝ™ëzï|z>Ïë5lù6í#œ¡õ.ÂüÐÅ4¶VÌ
yËÝY>naÿî«å[B>t/æ‹X¾×ü|ŸöñÇ8ê—­óú¹^a§hº÷üþgÔï-™—–óÇ0OEòƒËiù®–·¡C¨wÒîÇ}LùíÖû°? ý>Âøhã>F1†q¡~ÙºšîËs}¬`í¾óûOR×¼Ïrù©ç}ËÓ—kê¥ySão£—úÜ‚ñ¨í¡òi-ßÆžP?Tí®+è÷´bÛBÞt?æ-¸‰[h»Ÿð¼kÉº¦0öûstáy¹è’yµœ„¶œ‚0~ižšj^,/­åg÷3æ÷Ð/Ô‡hO`KB~ãÜÏ¡½ÆG{³˜Ç…úeëÆ¸ä>»8
Ïs¨;zÀrùmÚw‚ÆåéËõ
õÒ¼©ñO0Nýá‚ñlhùª–Ÿ¢éÂù†öô`@È×h?Â	Î„¼óAì/èÆ=ô¢ïAÂ|-YWÂ*ÖÐÿ`®³~>L®¸d^-§¢-§%Œ_š§‰š—Ë«iù-Ç”PŸ¥½‚‡Øò;!®§ÅxHx¿K{kxˆl
õËÖm=„ó/nc;î¯©ß\2/-Ç-ä¥yŠ?X°¼-_Òò#œõå:‡»¸÷Pá|G{‡x$ä·ÿ•ë=î ]èþWáç«KÖå°€Eõz˜ã=,ü¼‚\vÉ¼´œš0~ižä·,¯¬å·´|£B}‚ö<VðPÈÛÆùC¸ÿ0áùí%,ãV±&Ô/[g~8ïpkØx¸pD½iÉ¼´œ!/ÍS|qÁòlZ>§å{8êÇ´[ÁyÞÒÞÆ.ö…üæ>ûÚp¸³/œ—¬Ka³êõGr¼?R¸? —\2/-§,Œ_š§ùÍËËky³–÷cH¨ÐžÆyË£8£®ï´ç0E,aY¨_¶nŠ¦G3XÆê£…ûê&Z.¯–³¡-Ç&ä¥yò’Ï.XžEË§´|»Bý€öZ#'áýí‡ØÄ¶7=†y@nâÚ#œ—¬‹a“êõÇr¼?V¸? ]2/-'/Œ_š§yÓ‚å¥µüô1Æ¼}B}ö8f°(äMã>÷Ð÷8a|´g0‹y,`Q¨_¶nŒSœa9Êþî_È-™—–³%ä¥yÚ#Ÿ]°<“–Oiùv…úí3´>žã÷ñÂö¢ý›Øò¦'pü¢7qmOŽß%ëb˜À¤zý‰ìïOŽ_rÑ%óÒròÂø¥yj7-X^ZËOŸ`Ì{Ð'Ôic‹B~JûnŒã=1á÷ÅhÏâî“¸?xÒ¹Í0ŽIaü^Ú£ô—Ãâ“NŸŸ¯OTîß˜/ôbÓxˆ­®Ç´;0‹%!Dûö“™t>YØßißÑrîó•'Ÿ>õúN…¼)Î}?:ÑÞ¯Ñ¾ûŽCL?E¸¿£ý Øòé§²°‰í§
÷ÇOãuìbÿiÂç=ì7hy:÷ÑO_-¿'äóI®XÂýg­–÷ùaŠóä°ßáÎÏ‡h`ã˜À¤P¿l]Gýÿ9œçž#l_rí%óÒzÚÉï/¨Wó¥òA-_Â¡¾N{G8òáç²=±„•ç
ã£}„G8Á)Î„úeëüiæïyœ¿Ÿ'œÈù–Ì§Èe0‹¥´ðùIa^ÔøØÆÍËWó­òf-ïÇP¡=<ò–çsü£ÏÞÓžÃ<±„e¡~Ùº©úÿ¸ÿ|ð~˜ÜdÉ¼ê×Äë´	yi^¼ä³–gÑò)-ßÂ®P? }†ÖçŒðþ…ö¶°#ä-/¤_ÜDÚqû…ÂÏ»–¬K`ðEœç^$<¿'_2@®†ulã•æE/‰Sô,X¾šo•wjù$f„ú<íUlbOÈ;_Ìõã˜|±ðó.ÚëxˆMla[¨_¶ÎžåÿØË
ŸG&o[2¯úÝA'î	yi^bäk–çÔò-?Æ™Po~	û=ºÐ÷aÿ¥}ˆG8ò;ÿÉý*:ÑÜûÏùõËÖTû1þÿ>?M.¿d^ZÏ!õŽõZÞ¦å÷1&Ô'i/à6„¼-ÇyC¸ŸÞOÐ^Â2`kBý²uæ—ÒŽ‡/ž7-™—Ö3@¾° Þ¦å³Z¾‹¡þˆvóËØ¾¸û2á~„ö&¶±+ä-/çz‡›hC;n¿\¸Þ-Y—PíyÎ_yáx&_2/­g“zó‚ú¬–Ÿ½Ü˜ßC¿P¢=Y,	ùíÎWp¾Á½WÇ'í)Lcs˜ê—­©öWrúJáx&7\2/­§“|bAýÿÎ¯Gµ|B}›öÎÐú*ázI{°&ähãg*_à|Sžg/YTõ¯æ>ýÕÂñL.°d^õ»Lã•æ¥L~T8}yQ-ß×òÛ¸+Ô»ibSB¾Oûæk8?áök„ã™ö0îccê—­k©ö×r_öZáø'×\2/­ç&ùà‚úÿ/^÷iù<–„úÚ[ØÇ±9/a‹Eá~™ööqˆ#<ê—­ó¼ŽqãìuÂ÷¡w/™—Ö3G¾· > åÛZ~óõ\7_/\_i÷bcB¾M»é§¸ùáþ—v?0„aÜê—­««öÇYI8ß«-™—ÖÓDÞ» þç‹×ÝZ>9¡¾H{Û8òî7r^Á¦ß(ÜOÓÞÆ.ÏQ>K{þM\çßÌuèÍ§¯ï€üNµúv°‡Ö2çÇ²°ýÉÙq€a<{ô“Äf…þU.­åò+æ7ÞrúxÔë{èò!Ú˜Å’ŸÐžy+ó‹ý·
Ï¯i7½Ÿ+ãÎÛ„ëí›¶nW„û/õúÛéoæçœ°Žwç#ÚC˜XS}UÈ»ÞÉþ€e¬¾SèÅ|õ]<Wx7ó…õwó»¦|YÈ;ßÃuÐU®/¼îÇý³T¿-ÔwkÜG}€ã«Þÿû7œ¢íCÂóíß›«¹ñR£VMÚ1€Aì¼Ì¨ååÔ£í¸«éFúÐYÌ©~òFËXÉÿ¾£²t¼Ò¨]¸‡^`KšÝWñ=ùåïEÆpP4ZÐþn£›¿ÓèAú±õ£–ó‹3Üx#ß®é~ýcÃØÓ¼Ùh·Ìë8x‹Qï[öÞft 9ÖÜ¨µjÚÐŽbXÆ
Ö5›ØÂ.öpóí|9V4wÞÁþ‹ûÁªæ!6°ìã ï4âïe†Œ/Syˆlc½ï1ÚÑLWÙ_°Œ¬¾×hý}Fíï7êÐŒh64MüÝN3îà.0ˆILa+8ÒŒ}Àh]sªiû ëƒILaKsóClt£ËXA'wÔ…‡ØP~Øh;ØÇáXýÝÒµjÚÐŽ;¸‹nô _3¬ÑŒi&1…YÌaA³¤ø(ÛÃšUÍºfäÐhL³ªiþ˜Qú1Ž	,b	›ØÂ#£óãlliZ?aÔ¯Ç6±¥êFÄ$¦pˆ#Œ’þq†êïÜ~Ê¨­hC;îà.î¡ƒšûÁ8&0,b	«šuÍ†f;ØÇŽ4Çš¥¦ÑŠæTsãÓF«šuÍðgŒÎÔßþ,û©¦=˜Òlc·[œ¯qŸ¿ÁÂçº¾`´¥©þ>°ù{¼lcÇšŽŽÑ°¦ú{´^,hŽ4ÓüÝÓ&¾it“¿›¹…Ûü]I6ù»‹-ÜçïFÐ¤þ^–ù»vÜãï¾yqÈßoaš¿–Ámþ®–›ü}¬v±‡iþ^U‡8ú…ñïSµ0øk£êï99°ú[£êïåp¿÷ãÅêÔ¨÷ÏFøû,cÌŒöù{!<äïL4ÐÍßƒð`–¿ËC7ÁƒóŒFÎ7j2óó;´jî¡3š]ìáÎ¥ø¹Fù;1,]Æ¨Çb´£Ö¾÷È÷ëp‚SÜº¼Q¿fFS}¿}7ùžô-4o-ó=Û¬ñ=Ôuð=ÍAœð}ËSÌó=¿tò=¸.ìò}¶=Œó=ª	ÜTß/Š5¾‡³Ž¾3ˆûAëŽÑ(ÆvŒßgéÇÞªï¬à6ß“èÐ¾/ÑŒ5¾×¯Žö[­ßÚhˆïc€ï=¢ÿöF|O–k|¯UM|¯”k|¯S]w1ÚÇ&¼FSš5¬ãTsï®?XÄvîftÂ÷-M1ã3j¾‡Ñ$¦0}Oò˜ÇÖ5ÇšŽ{-ÝÛ¨?`´u£I¾ç …Óò{Ô1õûØüþóCüžfXý¾'¿_ÙC¿æW¿OÆïoµÔïñ{&~õû*üžCë‰ÆßWPÆâFgêóô|N>¨¹Ïçá#çóì	Ìc±û|Þ=¢>÷þ£fM7z0¥ÙÆn?“í‡Á¤Ñ$Ÿ‡O¡õßæ4MÏf<hásàVõùyõ¹pôh&4«šÛ|îØ]>/ÜCŸsô«Ï‘¾ØhœÏe%pô_Fƒ/3ÚÊu½ÊhåÕF·ŠF¯7j~£Qõó;¶Þb4Às÷ V5yÎÞÀ6Ï×;x„cÜäùönò<z;š=MËÛ÷Ð‹Í.öp[=‡Æ$¦Ðú£!ž÷†Õsß÷ÍiV4·ßÇòpóý¬/Æ1]ì¡…çÊVõ|Y3§Ùù€Ñ=ž'{1]g~°£y„ct}Xøþ^Ú‡X>ä<}(|‹œ²¥ÕŸø÷®—xH¿¡ÿ ¹4vÉ„|†\ËØÀ#U÷1áùýGÙh"·%äãä*h#·+äÛä¦è$çò3rÆ½…NôQê“l‡è¡q{Jù2íìàHÈ[>Áq€Nô}BøùOƒó(†1Ñ~>þIö?lbÿ“ÂÏ£ÿ›û&ãì¿çç/¶¢«ÖŸëå•›ì÷¸ýiæûÓÂç£?ËvÄ–?;?ï¡}ý˜òV­¿@‹óqKøùüŠùè¸Ât›õh¿A®…]­îÄñþ%Î[8Aï—…ùù
óƒ¬}Eøù.ícVÈÛµþÂ_å¾î«ÂçÅVÌ;¿Îõ}ß`;C8ÿ’ËaQ«;1?œŸö9¿D°ýqÎ?8á|2ÅÇÓßíx_x¼|Šó¡æøSç] ãuUÕr¶9>Â0V>½ÜxTnã3ë¿ê'ÒZOªŸŠæÆçŒÆ1‘ÏÝá8ÝÅN{=ãSý8¾h´ñÅgPË™àw8ÏìbâËËGåêšÖÎzÖGõÿêzúKÐOGsïkœgÑÕ5:Õ,|c=ãQý¿Éó,÷¸/º‰éø<ySÓÜó[þÛÜ·}‡ñb3˜ýŽðûTß™_Ÿòåïrú=öôa ƒß®o?àú†ír¿õCá÷÷~Ì|c+?~_XÈÕ„üÆO¸ŸÀà!v~rvëÝèÁ}!/å-¿¹d,ù¨°¼‚—ÆUÓçå§ÂçËhï`ò5¬cSÈK¹ŽÏxþ…,„ýWÈUGg6_Æ·£Æ+ôú%ýa‹¿ÞŸñ\Çš4	õu^?Ä&¶Ž–[Þ¢z5Ž°|©n ,ßJ»G›~'¿\O^­W ƒÆ#åJKæóXòéß²ÿa›¿>ßú®‹¸õ[£6ÜêÔñÇ¿Yny‹êÕ8ÒÂò¥:³wñºÇD­çïÖ“Wë•Äæ…ùr­%ó‡Øòä¹!ŽðèÂùÿ¼ÿEÏîa@¨7ÓnÁMÜZry‹êÕ8„þ¤º]!f¹j¶)ë9]O^­W+xøáþKÈ—Ìq$ä»3ÚÿÊ}<nþU¸¾ý…óFfF£˜œ	Ïƒhw¢=³å–·¨^£+ô'Õ…|†åªqì1/Ñ¿®'¯Ö«þExÞ+ä¶fËå-ä¬B~v±óï7.~¬Ýxâú»qÜÞÀÜÅŒæ±|±ùõAÚC¸‘‹-·¼Eõj3¡?©.%ä«,W#Ê¼ä/¾ž¼Z¯	NÑ"ŒGÊy–Ì;É¹„üöùÇí~ãþùóóÃK·°~žÑClŸ7¿>E{³˜;o¹å-ªWãØÆ/ÕU„å÷X®Gž~Ï_O^­—åÛÑ)ŒGÊE–Ì‡0,äÃ—>nÏ`—^o>²dÞm!ÌZæçgªŸËÛÑìâð2óë´±Œ•Ë,·¼EõjnaüR]CXþ˜å«qÒïÐ²ž¼Z/'ºÐ'ŒGÊ¥–ÌÇ1!äs—ã8Ç¶.·Þ|aÉ|ôòä±Ž‡—ŸŸß±·ïâÆåšpS¨oQ×Æ.ö¬Ë-oa=Ë
Ë—êÆÂòí´«q©õ»Âzòj½ö1‚Ia<R®ºd¾Œ!ßØäz…cœn®7ßZ2_¼yáÑ•„û¥+r}ÀÝ+uâžP?¥n†&ræ%—·¨^£(ô'ÕÙ…¼Ÿ¼‡íÊ¬ß•×“Wë•Ç\q~^Ê–Ìw±'ä}Wá¾Í6æÕ¶ž¼Ê…pçªFwÑƒcœ\U¸Ÿ¥Ÿ)n3]u¹å/ªWã*,9©›Wý6±‹=!¯ÆÃ<V®"\¯„\É|»B>ÁvÎc‹¶s“—r¾«[»:ç»«õ×`{ØÉáÈ.¼?º÷'Äýk­)]®·˜¼÷·×›Ÿ÷Ü€óz1pƒùy)ò•»!ÇÆ0éžÝú#ã–×söž¾üEõ*òz¿j=jR~‡ûZLazçô|CòR..äwnÄyè¹‘p%ä|7Zm~¢B>I»åŸÙ~¸÷ÏëÉ	yÏŠù]!¸	ÛÃ¸“ùù,íÊ–nrÁúWýL…z©.)äË»ÜãþMYÎM×“¯‘áÎv…ç#BÎ}“åò»79=ï¿ïó°ƒã›­'_òG+æB>yÎ+˜Áì-„ù§]YÇÖ-.Xÿªû-…ç}B]YX^ûæÜa–~k·\O¾OÎÊò7q[”Û_2\O¸8pŠ[·ZO¾-ä7WÌ›…|ù6Üwbk·æŸvå Ç·¹`ý«~¼ná~B¨kË›Üšv•§ß¾{=y9ºÑ'ŒGÊe—Ì§äK·åx¸Ç1zn·žüDÈ»WÌï
ù¶‡ó$ö°ïæÿ_Î7hÆ­¹`ý«~bB½T7Æg£Ý¡òj¼wXO~‡\÷1.ŒGÊÕ–ÌWä[ŒÓuGŽcŒÜq=yÛçç÷WÌ…üäNœ'qãÎÌÿ…ù§]¹‹ž;_°þU?¡^ª³	ù=ò~4Ý…åÜe=ù ¹f±x§ùy)×_2ßY3Î°—ãsÞõä÷¼óóÙó)!o»;çItàÎÝ…ù§]ÄÈÝ/XÿªŸ†P/Õí	ùèÝxN€;>–ã[O>I®Š5lÞMøù¾3Ý}¹ütA~ëXÀú=Ö“
ùÚŠùŠŸÞ“ýã^lgÜ½×zóKæ³´ç0â7Å¤_xÞA»Ýèñ/·¼Eõj]¡?©.(äS,WÃoŽ‡{¯'¯Ö«‰-ì	ó/å¶üËå-þÓó{÷aÿÅ&ï³ž|AÈVÌw…¼=À}ú1XoÞ±d¾F{s÷3šÇòý„çK´‡p#÷[ny‹êÕ8fBR]JÈWX®Gâþ<»ÿzòj½Žp¬æ]”ó,™w.ÈGÀý¡%¸ž|CÈ›WÌÏ0?ï} ÷A˜ÀÔ×›÷/™ïÓ>ÀúƒŒbûAÂù—ö4f1÷ å–·¨^cûÁÂçß„ºŠ°üËUã(ÑoëÁëÉ«õÚdù[èÆ#å"KæCò¥ÏÂ}
z²žüDÈ»WÌï
ùîCÙ_0f¿¯'?$·õ¯¼ÄîW…\tÉ|xA>M{s˜ò‡´+ØÁ$ë
_°å©~áåú“ú9Æozûn£ãaç&/åzè|÷/˜_oy8çkLaéáëÉ„|qÅ|NÈ[÷9~ÉqáG
ÏÇÃü<–ó$Î;?y"¹Ç)n<I¸ŸŽs¾ÅâÂû+ÕþŽOô<e=y•s`	{ØÇÁ‚zšÑ‚[Zÿe¬ã!6±£-ÿÄþ¿`9¥—³¨½þÄþ®-Qÿj;ø1 [ÊïaB^õÃ„Vwâ~ÿ©œg±ö§q~ÀÀÓ„åÑnNpÝ~:Ï¡Ÿ.|ž†œw±–Æ÷Ž<Âé3Ö“Ï?‹ý+XÅ6°…½g­§¿?O[Pw¦ù@Š÷uÂpj~>ö\'1ƒ5¬ã '¸ùá~ö:Òìgiá~†ÜÇ®ðyZú©`ÍÏã¾ÝÏ~Ÿö1ú_À<½@8þŸÏýnañùÂóGú9ÄNpŠöó‚Œ°=i7¿ãïEÌÏ‹„ãœw±öBá÷eègˆc´½˜q¢ý˜ÀV±ŽÙùË3Ó~ˆñû]N¸¾¿„õÆ8Öñ˜¥Ÿ’Ðß˜œó?ù9º±L]U¨÷¿ŒçXÆêËÖ“OÓ^Ðr‡kÊ{òÜçb·_¯a~^#|þ\»z%yê¶„úÈ«Ø0‰iÌ`‹xðªõôwb}Ôi¾È<T°†ªùz-Ç0Œy,áäµÂýM‘ã%Ž‹’p¾~ïï0‡ØÀ&æè§,ô7%çy=ëM®&ä·ÞÈz£wp{3ç7ï×ÉMqãMl§7	ç—·r=Cî¼UxžM»˜]S^åâØÃŽÑñ¶ÓëýÀ îký÷µþ'h¡ÿ-´Ë[´œž¶œñ‚å,ê_ïïÄópmù‹úWÛ!‡Åó¾¨^åGB~Æ8Ìö;Œ`‹á|B»ÿíœïßÁñúáy2¹&pöváó6Ì/p„G8Åwqô®5õ§?]Pw¦ùÜ;™oÆßA÷»…÷ïáüŠ‡ØxpUå<c´½—ã
½Âä{…ŸŸÓ¾û>ö»÷3þ÷çr~bÿ}Âõ£ÆöDÆ0åšð~…öà˜§rýøàü|œ\Shò[â>w1„aÌ`?$<¤=Vgû˜ùù°p¼“ËamBÞóÎÿÄ4f°Šuà·>Êþ‚‘
ïçhß>d=>Á~÷	á~†\GåÑþ1úANèÇÜÎ¿äŠXÂ2Z¨Ûê>Éù	7þ›ùÂÎg™ŸÏ
ï'É9?Åý=âuM¡~Ðd=qŠŸf¿D+n¡ãÓëéïÄýÌ‚º3ÍÇÈÕx}„¾Ï÷3-Î'Âf±-œ¡ùsœ_Ñ‹ÅÏ	ûíáÏ³_~‰íû%áx&·ùò¸Œ¢‹~|B%r#ô“	ùí-ì`{˜ú2Ç×W8}E¸Þ“+aw:Âç¿Æy	‹]–ŽorŽ>~SXúéã–êwÑÙ½`õú?©ß=!?¢ß	NqCÈo|óNÑþõäU.	rIàð,×»Ñƒþ¯ÏÃ„Ü]¾Þ_“°¿½o,Y÷Í·>'Œ· ô?‘òßâúˆ¬a¿uvê—­ë
õ¶Ÿq~F÷¯Øþ¿Þoÿœý½ä|B^åò ò*×Å0¹}!oþãÀ(¹˜Ï’+`+x€Õ_œúeëZB½ûˆõE1„á£³S¿l]B¨/Ó>T9¶SRØ^*çø%ç5r!¯r!Ì‘«aM¿æ~·Ñ‹±_ó'ôŸÿÕéyî¡ÿ—Âû!òyaýš¿:=_À"V„¼”«	ùãìüÒ˜«ùÙ/ç};œ8ÿüŽû´L¸œ,—·.È§~Ï~†Ìÿ^x~/äJB¾L{°.ä¥\SÈO¦Ü?ÿ‰ùD'ºÑó'áùï‚zýŸÔ¯êU{sXòû+æU.¥å‚>»ù‰0žì_ØžØÀî_„ãIÈw¤üŒã‡e¿ÿÛrùÑ‚¼ÊYÈm¡þëÙ©Ÿ,¨?q~ò!/õëÑÆUø«ôý›æãí„Ù‹k¾„ù¬ä»òI^Ocœ\qMù ÊáÜdMùìÅŽÛMäË—0ÖeLÇ–Lóë­Ô0ˆû›Ÿ¯Òý’Çî¢ÿ’ëÉ›.9?ï[1ïòƒóŽÛpŒ3Ü8Ÿù<ÿìÔ/[gê£W:n¯bþªÇ®:?¾2Û_I®,äUnˆäªB^å¶·Ž­“;òArl’k	ù>¹ág¸ñOg§~Ùº-¡>G{Kx€U¬¥úeëÚBýŒv÷UŽí°ºÂöR¹öÉ„¼ÊÕpDÎbc^1„aLb	[¶ùýç…þ®zz¾€E¬\e~^ÊÕ„ü‘°~6Ûéù1NÔ¸…¼”³ùãthã²
ùÀUç};èÿ"öãöî_óØÜ5—ËGäU»ùZÌ'º®µžü‘w®˜wùímì`_ÈK¹‘4ÚÇ8Q¹kû³ùÞu¸þ^÷Øt^w~^µpãBÞµb^µg1‡E!¯ÚkØÆ¾/­˜W¹C-¼û7f®wáÖ;…¼ûzóûO¯˜Où ƒó`Í!ŒŸö.Žp*äë+æ]×güÅôõ…õ]1¯Ú³Ø»÷y7\.ß_W¹r»¸‡~ÝàìÔOÔŸøù–Sýf„¼éFì¯¸QÌ`ãÆóë'»ÜŸÞ„ó†0Õ›Í¯ïÐ>¾9×Å[p½¾…ðþàæ«å=´G]lw,¸NÏ‡—Ìû]«å;´w±t[æç¶«åÖ”W¹nÝŠëé­VËo¯)¯r5ä,B>p{îÑäa¿ðœž/.™ÝýóXºÃéý×µþ·ÐçY­?ÕO“ZÝ‰Ÿ§Ñ¿Ëä…üäŽì¿{ä°µwz>°d~ó.loôað.§÷Óúï éN«õ§úÉ£S«;±¿’›bˆ\\Èh¯ß•ý‡wŸ¯Üuµ¼ùnŒÛÇ¼cØwzÞ±d~Ë·Z¾@{Ë÷f}î½Z¾º¦¼Ê•p€ßjù£5åUî[Øòéûðþÿ¾Üßaü¾§ç]Kæ3÷ã>óXÇ!nÞ_x¿ÎëU-?»ßü|Sè×uÿÓó}-¿#äU?nô`vÅ|Ã˜êwÜOa[heÜ{¨æ[O—ºYÀX¿ßéù‰–	ùüŽÛ½AÆƒù ð¼ý<OÂ4Ž¸Z>‹9ì/YßÆ®Wý`M«Óÿí=„ùEÇC9>ôôütÉün˜ýÝÂÖÂÂû!_ò¡ßîŠù–Wýô°ö‡­–·ù#æqŒ[ÿÊø°Ü]°ü<¹šVg¯–7ùêÃ9cM8=_Ã	Î.œïè§C4ïs~Â Æ0³/Ü/iõ*Ÿ\S^OrÁxVÍï<Šó±ö(áç´ï=šûhL?Z¸Ð/6±Þ?†~1îžÆý)FžÎú`	pï¼ï†ðóU­?½þLóúøgÕ¼•œóÚ<œi>®åªŒ£þŒõä÷ŸÍûwÜýÎóÁ8ZžÃyí9ÂýšÖŸ^¦y}|‹Æ³j¾—â<…!mÎ4¯Æ¡r	Æ‘zÎzòÎ°|t½ˆû8lbçEÂùC«_w¾AÎ”á~”\J«ëõS­~Ýy5Žºš¯sý±ð¼„~K8¤Î¤Õ…ú¬V¿î¼‡³Yê³ÂÏƒèWÙÁAF˜_ÚÝ/ä|Éröµq…ñ9^h¬_w^£ˆeÖ».¬„~•QL¾Px>KûÑµýæEëÉ—w·^ÂýâKÖ“ï¾”û£—±?åy€û¯à¾éÂý•V¿î|˜\7ÈÙµº¤P_Ðê×Wãâþ+9O¿Røüýz^Î}uåWëÒBýÎËõëÎ«qôqçUÔ¿Jøüý*c˜z¹0¿´÷qÈrLÚ¸rÂøZZýºójnÜc½ƒÂú›9N”´å…ëíÙ¼¶ß¼b=yãcq7^µž|ñu¼ŽmŒ¿~~~Cåy=Tâ~½$</~yô—Œugšï¾‘ýGoåýë[×“¯Ð~€5¬¯)/å:B~ðÖùãÞyÛjy3yëÛN¯÷’÷¡Âø¤\hÉíá]°>ÿ»ÝpúrÔ™pó­g§~ò–åêl¸Ëzx1Táý±RYnyRÿNt¡[[^˜Ä4æ–\¾Þß‰Ÿ—-ß¢åéã×Ç{âŸ6ÿÒ<ì½mµy(,¹¼¹¨÷«õÆ¶°Ý·]¸õ%!_Z±ÿ#Úm¬¿w„ùp½Ã$¦0ƒùáþÉºâÁéçuü;ÞÄ~ƒ;eö[Tûÿ¢ùWÇ¯ëìw¨Ö·‚ýÒïOßXŸWŸñ…ßrnÆ«Æ¹ÁøŠUž?W×“w3/f«Æº6/`ý‰÷Ë´aâ}Ìãû„Ï«¬˜7±ÞVÜ{ÇÃ»Ö“¯³]Ûhe»î¢ó]Æ~"ú;ÔúÛ\Ðß‰ç—´çq‹yqó“X1abJíÿo~~§å
Xò]Ö{€ö£Ž:¿0NÓ».`½¾?©ã7é×®–ó^Úß+,ïëï2n× ¹f1wëO¼ßdÞ“ÚvËiÛ¥ô–Óëã˜Á¬ÏiÛ]õ[òuŽ»CœáÆ›—;ÏFßÎùml;N™§vßÍst½‡ó3šÞÏý;úÐÿþÿÿ¼ñ—wÿ[Ÿ!ŽÎÑú¨ýCšçç_Ö7MîcÆååò­y•[4Ïæ7_¸õÝ7	çëûß.Ï¿ôc ‹XÂš0_ö7_°þšB‹êÔ}ƒ~ßY§ðù‡wÏßoÍì¯Ž÷ÌßïÞß\Hýß-ü|å—·¨þÄÏ3ß9ÿ¼àÄç…ŽÞ5ÿ¼±ùî‹vÿáþ«z†Ë_T/¯?ôãm¼àøX´þ«žç“¼_9à¼ÞÀ)Zkç¼ïë	ïÿfÚûPuŸ;‘žŸ¼e~~,ä;ï[îº|ÿ…[¿-ä·Wì¿«½Ößïm¿iþö°~H¸ÿ&çÂÈx¿óÕòÉ5å“ä†h"·»æ|kØ®	Ç³–ë®¸<½~“œ]ÈKýo
y5¯Ì‘;\2Ÿ_÷’ó¡CÂ|I¹HíôýC-“ýuG8ÄiÏ`ýºñ¡õäsáú€;eÿýèzòQÚc˜Á–±"Ô/ª“òqLiõú¿íMlaïPøyàÇ¸. õãltü7×Ÿÿ¾pëm~_ˆö%û‘K©þ>Áñ£¤Îw!×[>1?¯ÚmKöŸ!WPùËÃ uûr½¯!œ_h-Ù‰\w?Éñ§¤.y!×»?)<¦Ý·dÿAaÿ×÷}~õñäq‚ÓOÎ?>ôýIŸÿEã2N3ãË`ëãó—saÕç…ó…j//ÙÿˆÜKÌûàóçíÂª?ÎªýpÉþì7.¬ã´1?¸°ê›ÂùBµw—ìKí÷ÚqÑý¤q¿Î\Èõ%á|¡Ú«Kö_ö}ÑçWÏø“gv^ÆçûÏ‘1ŽIlbçSËÕ/Ê«ö®ZN“õl
çgÚ=¸‡^!jû-àmŸf~?½Üø¶š§çKŸe½±ƒ¡–ðþš×x}ïó¬ÿç…Ïo“s}ŽõÆÈçÖ“·}n~~Å|PÈçh¯¨ºÏ×ûLóµ/0ÿhêñ~¯·ž|é›\°Šµo®'/åšØÆÎ‚ú
Ö±!äÕz:p}Âú‡¿Âþ€QŒa
³XÅŽÑñUÞ û«Ë-Oê¿Ž‡ØÐ–7A3Ë±à&Ú—\¾ÞŸþoÑø-O¿>Þïgµù—æ¡µâ<8–\ÞLÍƒ/°ß•ìÇýožú¢Pßúærçƒº¿«ýY_:žÔrÚ_Xn9ë®¯}‹ÏÃ å;œ_Ñ‹Áïœ^ßÄv°C´ÒÏ6:pÝÚò¥åÕµþ6…ü¢q©õ]v\‹ú×ëOÜOhË_Ôÿ„ÜÎ·ÉcòÛg7ïò)Æ™Æ±ŒUa}–­«çôãSíïm¶#v¾Äý:,§c<ž¥ã³¶`þJØf|Ïç§·«×.Œ·ñeîC:ñ«q÷ÑCÿáo­'Ÿý¦q=v¿e¬;Ó|”ö,¿Ëýïw…ç}+æ‡¬ç{l‡io=yÛ9ŒÑ.ãÃVÏØþÏ¯ÕÇV¬7©óNûÜ?óa^1oa¿¶â6::Âýª–s£GÈGXï8XÏýÞzòª=†uâ€ãl,œÏ"gXØ3nG'ó½×_O^m»¶]œÚ¼ïuN¯ßÂÜòNm»ª~CB>Äy4ŒU<ÄÈ9n°ŽM<b;§¾Æù‘ã¢Œ¦¯³ÿbûèúãýÆéçÝÌ·ÿoüóÆ¿Í¸èùÚÿ[ë?Çë£öižO<ße=v1ÂýHþËËå£òÿÛ¯0g+Ÿò­/Í¿›à÷X/…õëñ‚õú[T—îíÂû½â’ûYèÂó¬³T?ùºðy%¡ÿ=,Xžë+Æûæ\w¹ãÐñõ‹V‡]áûÄÔŸx¿*ŒÏŠöãu,8¥ý?¿`]u>í1õ¼‡ûÎ1VxŸs(¼ß)}Ùø>LÝ¦…ç[åóê}Ÿt9[ùdûô÷§êýšþþdöãüe™·±0æïñ<=ßg<ß_-XS^åìFëYÊ×q†æï¯V?ÑêOl_Ú¡ßü÷—ËGäwÉ9Ñ…{Âx¤œÿ{§o?µü#5arÓîÇòØÿ°žüÎÈa»?ZO>#ä;+æ›B~Fûæó*–‡ëÉ÷ià­?¦Üú±ð}ê¤üÇZý‰ëý¸Ð}¡ÿòO8_£ý§çèýç“_\¸õ;?ö7ÚÝKöŸ"WÄ­÷«¦.z!×o„Ï_Óî\²ÿ¹ª×ÏØ1A]úB®ßÿ™ð|ˆöø’ý×ÉuÑÿsî‹”Ô/äúÐÏ…÷Ë´G—ì?,ìÿúþ¢Ï¯>žn²œ­_Ì?>ôýIŸÿEã5ýtþ8û?¿œ«¾"œ/T{}ÉþgÚ¼×q:š?oV}S8_¨öî’ý{Ô~£íG›?Ÿ¿\Xõá|¡ÚÇ?[®çÏç“Ÿ÷ëÊ…\ßÎª½³dÿ‹Îjñ/8OXÏð¼ /zÄû",`	'¸ñËåêåó¿bý~ÍýóïX¿‰p¿=æç£¸‰Ûcá÷÷hâg*ÿúÃmtüæôþú8Á©°ü¾°ü‰_uœ'~>Fû>F0iÌ,¨`ÃB^ÏÅ0.ä—WiÅú¤O²¥0ƒaÿªÒÞÀÊïy~€•?qþéÂ­¯ý^xÞA{sÉþýäÂèÿçlP×¾ëCîÇh.ÙÜîÙ?È¥×”Ÿ‘·,™÷“«üÑ˜Ë­)W¹%ómÿrhÛCío3mû´é~½2®¿Zž¾ÿ-Ú^}Æ1ÀN…ãÓÊ¸ìÚ8Ý˜¿Ü«Þ,ì¿ª}kÉþsôWú½qÞ-Sã<ö.äúÞ…ã‡öÑ—ë?À8¦Æý¦¸¦|‚\fÉ|›Ü¶–«¬)?&¿±d¾51î_m{HÇ¥gÅãPÚ>ûæzŠ)L«öãù«ðy8rY< WÅŽ/¢õ¾¿1¿Àøß„óµ–KcæåSB.¿b>·¦|å¯§o‡3ÍŸØÞXEÕßwgKoöNpóÖ“—Ž/5þ²6~ëlµþU?9ôü…ë6&0÷—