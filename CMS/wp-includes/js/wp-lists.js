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
				$element.css( 'backgrounn�y_���Q�x��u��y,,�ߞПޏ�\@ț�߂���r�y>�!L`F�{^�xы�W
�#-Wz��U��i�3���~��
y����|����q�V��ma��7��}!�8�~5������Y��C�΁�.�o���?���~��B>AN͋���yQ��~��水��8�ѯO[~PXޙ�w�������
�S!��"�O^�y˯�_��8y=��XO��A�ߨ�.�/��h���Bz?Ere!d9!������~�-�	��/��F�����ob��i~�K{����7�/�n�C��W90$�Ըq��S�m��Xi�D����)s^�!:�������\X��hu	�������D׊���^Z?j���[̇���6/j�;������e=�;q~���-�"��t�)�m�Gh�p>r!��<pR�_�w�����,a���F]���y�yz�]K�7ƣ�sDn"�+�����?��}�[���0^��@�~h9ϻ�.�~~J�#�iڳ�ǂ�W���@Ȼ�Ÿч~�`�]����1�I!�{��F��	�X�ίWu���BZ]��e��{zi̬����������EN�KO���$vq����.zִ��7ڏ��O�����C��}܇`�}��T�%�|������j��K{�`�1n~P�ߨ��N��-�Ocf���Bz?nr{B~Jn�&�c���y'�}���߭3^t�^]�~h�܇�.��Ҟ�:6�|��>q$�Un��	��7��u<ֿJ{[��ŏ�:�?���]�~T��3uZ݁V�u�yG�����ފ���^Z?j�%!!����Q㼨�q�~<��1LanM�;q~�_��|���3��c�0���	�S!��s��	���������a��ᓬ'�R��T����[���П�O�\^�{Y�l�����ul	����l|J��r�Os>���О�
օ���u�����0�A!��O|�����������%���|�X����.�c��ϝ�_�+�����Q˟�rj^l�5΋Z�����4�������Ԗ�����2l��6?z��뛟7֟؟���?(�K_`�����i�i��K,�X��p>�n닧��H������a��O\/�~���B>�r�1�-����_��ƅ��+��Ё��g-W�*��W�����۸�ί	�����"���Ti�a�B����t����9N��u�|@>�����F����qz��\���G�~��c��+̇���6/j�q��L-�~�k�_�7�}�-�$,o���x��{���9�k�'~>��T�=!o��?�����h`�;,-}�/��盩+|���0F���� �V����P�G-?&�{�hay^���w��ԍp�a���g�1���>OK��8��	���C-g��V����~����������K����|�~�B7z�',o�v'�&�[�K;��3��'�0�%,ck?����]�a_������݇A	���c�wpw~,|��'�ǘ1O?c|?g��B8��� o�͟	ۏ�����υ����S�v�qձu�z����fh��V~���
�X�+�l�T�<����]a��x�~w���x��A�0�E�R滇C	��/y��!�����`�7��-!�e?w�nT�y���\m׼�/Y�	N1���vtv�/���2V��١�E'�G��L�)����B7�	�1cm>ghf-�|����r�����������.��<t�F�} ^7��p[Տ����6�%�g#�ߦ��=����� ��8&~+�/i7�=��)l�8�)�bN�OT��큛�y��cQȷ~�s�?����ONOϷq��������$��(l?��?�?���D�D?X�C��}�a�Ol��p3c;��y��0>�G8��_�����.:��m������������&�������w��O��u��bg�|	����x�X0�E��{�ol/t�M�^�^�
y�͌�
�s��,��A��,�Oq��tG�_���u�_W}_o�_��ﳝ��I���q4���}��C��L}��7hT}?X���(�0���FY�{#��G�>Ѩ�~���sV֟aT�>�R�^�����ٟo��5��=�>��y���-�;|^Y}�����E�烕I>o�>�g�sr���l�6�+Q�/	������P�����yh��[V>n�y�R�\@��}����A4��J=;�yٸg|>�S�k~e4�{�����a{���<~ނ��;E�%.9�xI�^�VV̗�Q�m:na#�����(�g��#M��hV�/}�q�V�s��|�~:��K�kq���u�����,�x��˝�|v�|�z�>C���?�pn���{��g����M>�b�}���>�����h���py#ܼ��?�������y5a{���!�m�&^1�R�uu�?������7����Ў�׺h�o���L�w�|�\��}�96}a{��`���&�\1��q{M78�q�x�.����=�|�;6�ǹ�OV��믖���[v��S�A�?���c���Yoߔ�;ܽ�[�p2/N�x��������,7�{l7ozn򛻫�7�?o&a}G�<���ܼ�q{����ﮘ���=v�c��>7��[��?��1��5������������:60�97���y�YO4���'��܉�1ΰx�s�/���ݕ��n�Z����&�b�r��y�66�un���{s|��X7��{n��U���q{]A��$����ݟ��<���'+�7C�?0�Q�a
��z��g�k�?�y�����h�4�%t\��z��-�}<���n��qe��q�Ռ�W�e�oU�{��6��9��ni��"���r=B�#?��l'���>��-�Ndt�0��G�ߞ�b|�@ϣ��+��1�͙Z�>�5�-M�#ٞ� ְ�H���qa�=ڇ8B�����q�|���3"�O{�1/�k�7�����y2�-Z����y�S8Np�O�'���)c�B�Y�����%�OA������>G��Ǳ���cÏ7��D��y��̯��ϊ#M��8�3�v���9���9M�3Y_'�6��:�m4�2j}���s�N�F��c�Xմ?�hK8z�����V=���[/5�tVP����v7��W�G�C����-�߸���A���W0OXy�p[���M�`������W�]^m̅�����������SXx��|����o`����y�[Y>�����.�C�������?�ƻ8�k~��n~����p��GxTc}?�8p�B�N����������^�����>�u͟��3��=B��9�'b���B>�f{}����/��ic�x���'B��eƏ)�Yؿ;�8Í���6��*��W���8��пj���~�_=}<~���|iɼ������zMx�K��fr6!�r�ILu��\^�;io�D�.̏��E�o��D/������Ў���#�B��ry}�!_��}�����	��F����n�1�h���K�m!ߤ� ��1'��Z>�E!_���=<�oq}�*־%�G�5��>�o��c����`-��!_���#�	��w7b�;��&�B>N���~�����O�;�'䃴�1�E!��.�1���
�rq!�I{�8�1��#!?�}�{���'����	�T���x�ܦ�����zSB>��#���k�¾��8�����0!W��G����?�_Z�LnGȻh`�B��C�+t���x�\@�OXn��k��]-_�����>A�����|��.�q ��D��iw����bT�'h�c�|��W��ԏ�����w����D8�i�Z���N�bHț�q�6��T��s
�.ˍ�zKB���3x ��wq�3!_q\�!6F�x�\W��i7��yA�τ�w�O�i�c�B~��l����O�ױ��_��N�bH�;�x_��<��_r>��_��_	��"���
�~uz��%�q�sh�5�a-����Z�ܟ���[����oؾ�����B�|�~M�庈��
�ô�1�!?V���<f'���p��c�N���{����������|v�|W�wX��%�nڃh���������%V��G����cW�;�W��T����'�3��I�hb�B^�'���?�>�z;B�O�-�:�g�����q�[a��E���P7��z�	�u5��0��E�bS�;����X�v�*<����7����iw�ה��Q��z��u5?��xb�g��5!��?�'c������c��p�����_�i��6�֔�q �ռI{]�Ϟ0?�QLa^�i�\�X/�.vz���ul
��G����yqa>i���Z/1?o�݅~��#�=&�}�����ױ)�;���/��^r~>J{��Y���w�����h�aB~D���8��W�\����M�\f�|\ȷ.{�>E�?0��pn�m-o�	������ϧh�`������6�0>��X�C!_�<�{Χ������=��Lȧi/b�W8}<�d�7�o1�����]���"��S�MWd�z��y)�-����4�|Y�'�(�+�7��GB�p%�V�v%a<B�)��i�]��c����{Z>�9!_���m�����5?/�jB>@�7��X�?��;���܎�w��&���*��N���U��������)�o_��ݫ
ǣ��"��^��1�Y!�1n���&�oBn_țh/`;B~xUc��}!?��t5�w�6?ߣ}�G8�R�tu�x�u��cLȧ�|�B>C{���kp��,�!�Gȕ���=4�9���緵�mB�A�1*䷮�q�;�{Ma<BnO�Yn���X�M-_�C!ߢ}�S�\k~�N{���Rn(�Ӵo]�yA���뗖waH�GhOc�|p��
���#��B~��:q,�MZ��3!o��'��w���v�u��z]a<Bn[�7�?��i�	���O`Q�Whob��|�zWx���	�rM!�O�������ȹ����}L`VȻ��q�>�__����&��Ď�:��:����v��ܹ��|��#��tA>vC�7���ő���|tވ���0�G��g�o��p��;���o|z��u��>�),bU�[w��X��盰���7�_^�b�7�������@�N{G8�1<B�s~~����1rs����<��H�W����{���Ғ�^oa�\V�wo�y��皟?���g�$�ho��B�{+�_<�ꭄ��#ܼ5�[�޿z݉!�=�I�	����������m���B]dMy5��6����nqsC�[�޷�x�#�ݎ�軝PO{��^S~ �kgM��m�����	��j�=�/:n/<�}�x�.���#��X���a\�5��7����Pȷh�-�2?���l.�oށ�Nt�A8�о�	�
��;r�����u�W��}!�c}���=���v�X_t�IX_��1�Y!?T�ݙ�z�|z>��5l�6�#���.����4�V�
y��Y>na���[B>t/��X���|����8ꗭ���^a�h����g��-����Ǐ0OE��i�����C�w���}L�����?��>��h�>F1�q�~ٺ���s}�`���OR׼�r���}��ӗk�yS�o���܂���i-�ƞP?T��+���b�B�t?�-��[h���kɺ�0���st�y��y������0~i��j^,/��g�3���/ԇhO`KB~��ϡ��G{�����e�Ƹ�>�8
�s�;z�r�m�w������
�Ҽ��O0N���lh�����������`@��h?�	΄��A�/��=���A�|-YW�*���`��~>L��d^-��-�%�_�����˫i�-ǔP�������;!���xHx�K{kx�l
���m=��/nc;�\2/-�-�y��?X��-_��#���:����P�|G{�x$����=�]��W��K�尀E�z��=,���\vɼ���0~i��,��巴|�B}��<V�P����C��0���%,�V�&�/[g~8�pk�x�pD�iɼ��!/�S�|q��lZ>��{8�Ǵ[�y������.����>��p��/���Ka���Gr�?R�? �\2/-�,�_������ky���cH��О�yˣ8�����0�E,aY�_�n��G3X�ꣅ��&�Z.����-�&�y��.X�E˧�|�B���Z#'����Ķ�7=�y@n��#����a����r�?V�? ]2/-'/�_��yӂ奵��1Ƽ}B}��8f�(�M��>���8a|�g0�y,`Q�_�n�S�a9���_�-����%�y�#�]�<��Oi�v���3�>�����������'p��7qmO��%�b���z����O�_r�%��r����yj�7-X^Z�O�`�{�'�i�c�B~J�n��=1���h��?xҹ�0�Ia�^ڣ����N���OT�ߘ/�b�x���Ǵ;0�%!D����t>Y��i��r��'�>��N��)�}?:�ޯѾ��CL?E���� ��駲����
��O�u�b�i��=�7hy:��O_-�'��I�X��g����a�������χh�`���P�l]G��9��#l_r�%��z���/�W��A-_���N{G8���=����
�}�G8�)΄�e��i��y���'����̧�e0�����Ia^������W��f-�ǐP�=�<��s����Ӟ�<��e�~ٺ�����|��~��dɼ�����	yi^���g��)-�®P?�}��珌������#�-/�_�D�q���ϻ��K`�E��^$<�'_2@��ul��E�/�S�,X��o�wj�$f��<�UlbO�;_���|���.��x�Mla[�_�Ξ����
�G&o[2���A'�	yi^b�k����-?ƙPo~	�=���a��}�G8�;���*:э�������T�1��>?M.�d^Z�!���Zަ��1&�'i/�6��-�yC���O�^�2`kB��u�Ҏ�/��7-���3@���ަ�Z�����v��ؾ��2�~��&��+�-/�z��hC;n�\��-Y�P�y�_y�x&_2/�g�z������ܘ�C�P�=�Y,	���Wp���W�'�)Lcs�ꗭ��Wr�J�x&7\2/���|bA����G�|B}�����*�zI{�&�h�g*_�|S�g/YT���>����L.�d^���L��L~T8}yQ-���۸+ԻibSB�O��k8?��k���0�ccꗭk���r_�Z��'�\2/��&������/^�i�<����[�Ǳ�9/a�E�~���q�#<ꗭ�q��u����w/���3G���>���Z~��\7_/\_i�bcB�M��������v?0�a�ꗭ����YI8ߐ�-����D޻�����Z>�9��H{�8��7r^���(�O���.�Q>K{�M\���u�ͧ���N��v���2�ǲ����q�a<{���f��U.���+�7�r�x��{��!��Œ��Оy+���
ϯi7���+��ۄ���nW��/�����o������w�#�C�XS}UȻ����e��S��|�]<Wx7��w�|Y�;��u�U�/�����T�-�wk�G}�������7���C���ߛ���R�VM�1�A�̨��ԣ��F�ЏY̩~�F�X������t�Ҩ]��^`K��W�=���E�pP4Z��n�����A������3�x#���~�c�����h���8x�Q�[���ft�9�ܨ�j�ЎbX�
�5���.�p��|9V4w��������!6���� �4��e��/Sy�lc��1��LW�_�����h�}F��7�Ќh64M��N3��.0�ILa+8Ҍ}�h]s�i� �ILaKs�Clt��XA'wԅ��P~�h;���X��ҏ�j�Ў;��n��_3�ьi&1�Y�aA���(�ÚUͺf��hL��i��Q�1�	,b	���#���lliZ?aԯ�6���F�$�p�#���q����~ʨ�hC;��.�����8&0�,b	��u͆f;���4ǚ��ъ�Ts��F��u��g�����,���=��lc�[��q����獺�`����>��{�lcǚ��Ѱ��{�^,h�4����&�it�������]I6���-���FФ�^���v���yq��oa����m�����}�v��i�^U�8����S�0�k���99��[����p������Ԩ��F���,c̌��{!<��L4��߃�`��ːC7����F�7j2��;�j�3�]��Υ��F�;1,]ƨ�b��־����p�Sܺ�Q�fFS}�}7���-4o-�=���=�u�=�A��}�S��=�t�=�.��}�=��=�	�T�/�5�����3��A��(�v��g��ލ�����6ߓ�о/ь5�ׯ��[���h��c��=���F�|O�k|�UM|��k|�S]w1��&�FS�5��Ts�?X�v�ft��-M1�3j���$�0}O���5ǚ�{-�ۨ?`�u�I�� ����{�1������C��fX��'�_�C��W�O��o����{&~��*��C���WP��Fg���|N>�����#���	�c���|�=�>���fM7z0���n?�����$��O��ߍ�4M�f<h�s�V��y��p�h&4���|�؁]>/�C�s��ϑ��h��e%p�_F�/3��u��h��F��F�7j~�Q��;��b4�s� V5y���6��;x�c����n�<z;�=M���Ћ�.�p[=��$����!����s���iV4����p���/�1�]졅��V�|Y3�����=�'{1]g~��y�ct}X��^ڇX>�<}(|����՟����xH��� �4vɍ�|�\���#U�1���G�h"�%���*h#�+����$��3rƽ�N�Q�l��q{J�2���H�[>�q�N�}B��O��(�1�~>�I�?lb���ϣ���&����/���֟�啛����i�����?�v��?;?�}���V��@��qK���������t��h�A��]�����%�[8A��
��}E��.�cV�۵��_�����V�;���}�`;C8���aQ�;1?���9�D��q�?8�|2�����x_x�|����S�]��uU�r�9>�0V>��xTn�3���'�ZO�������1�����8��N{=�S�8�h���gP˙�w8��b��ˍG����z�G���z�K�OGs�k�g��5:�,|c=�Q����,��/����<yS���[��ܷ}��b3�����Tߙ_����r�=��a ���o?����r��C���~�|c+?~_X�Մ��O����!v~rv����}!/�-��d,��������U������h�`�5�cS�K���ύx��,���W�UGg6_Ʒ��+��%�a��ޟ�\ǚ4	�u^?�&���[ޢz5���|�n ,�J�G�~'�\O^�W ��#�JK��X��߲�a��>������[�6����ǿYny���8���:��w��D���֓W�����r�%����!��������E���a@�7�n�M�Zry���8����]!f�j�)�9]O^�W+x���Kȍ��q$�3���}<n�U�����FfF���	σhw�=�喷�^��+�'��|��q�1/ѿ�'�֫��Ex�+�f��-�B~v���7.~��x���q����Ō�|���A�C����-��E�j3�?�.%�,W�#ʼ�/���Z�	N�"�G�y��;ɹ������~������K���~��Cl�7�>E{��;o��-�W���/�U���X�G�~�_O^������)�G�E�̇0,�×>n�`�^o>�d�m!��Z��g��������2�������,��E�jna�R]CX���q��в��Z/'��'�Gʥ���1!�s��8��.��|a�|��䱎����߱����博pS�oQ��.���-oa=ˍ
˗�����q����z�j��1�Ia<R��d��!���z�c�n�7�Z2_�y�ѕ���+r}��+u�P?�n�&r�%���^��(�'�م�����ʬߕדW��\q~^���w�'�}W��6�ն��ʅp�Fwуc�\U����)n�3]u��/�W�*,9���W�6��=!�Ɲ�<V�"\��\�|�B>�v�c��s��r��[�:绫��`{����.�?��'��k�)]������כ��܀�z1p��y)���!��0�����#㖐�s����E�*�z�j=jR~��ZLaz��|C�R..�wn�y�蹑p%�|7Zm~�B>I���~�����	yϊ�]!�	�ø���,���nr��W�L�z�.)�˻���MY�Mד����v��#B�}���79=���㛭'_�G+�B>y�+���-���]Y��-.X���-��}B]YX^���a�~k�\O�O���7q[���_2\�O�8p�[�ZO�-�7W̛�|�6�wbk��v� Ƿ�`��~�n�~B�k˛ܚv��߾{=y9��'�G�e�̧�K��x��1zn���DȻW��
����$�����_�7hƭ�`��~bB�T7�g�ݡ�j�wXO~�\�1.�G�Ֆ�W�[��uG�c��q=y����W����N�'q��������]���;_��U?�^��	�=�~4݅��e=� �f�x��y)�_2�Y�3ΰ��s���������)!o�;�It��݅��]���/X����P/��	���xN�;>��[O>I��5l�M����3�}��tA~�X��=֓�
�ڊ����ޓ��^lgܽ�z�K泴�0�7Ť_x�A����/��E�j]�?�.(�S,W��o��{�'�֫�-�	�/����-���{�a��&ﳞ|A�V�w��=�}�1Xoޱd�F{s�3������K��p#�[ny���8fBR]J�WX�G��<��z�j��p��]���,�w.�G���%��|CțW��0?�} �A���כ�/���>����b�A����4f1��喷�^�c����߄�����U�(�o���ɫ��d�[��#�"K�C���}
z���DȻW��
��C�_0f��'?$�����ĝ�W�\t�|xA>M{s��+��$�
_��~�����9�oz�n��a�&/�z�|�/��_oy8�kLa�����|q�|N�[�9~�q��G
����<��$�;?y"��)n<I���s�����+���O�<e=y�s`	{����z�т[Z�e��!6��-����`9���������-Q�j;�1��[��aB^�ÄVw�~���g����q~��ӄ��nNp�~:ϡ�.|���w�����<��3֓�?��+X�6���g���?O[Pw��@��u�pj~>�\'1�5�� '���~��:��gi�~�����yZ��`�����~���1�_�<�@8����na����G�9�Np��󂁌�=i7����E�ϋ�㏜w��B��e�g�c���q����V�����3�~���]N������8�������ߘ��?�9��L]U�����X���֓O�^�r�k�{���b�_��a~^#|��\�z%y궄�ȫ�0�i�`�x���wb}ԝi��<T����z-�0�y,����M��%���p�~��0����&��,�7%�y=�M�&���z�wp{3�7���Mq�Ml�7	痷r=C�Ux�M��]S^����������� �k����'h��-��[�������,�_����pm���W�!���^�GB~�8��;�`��|B���������y2�&p�v��6�/p�G8ōwq��5��?]Pw���;�o��A����������x�pU�<�c����
���{���Ӿ�>���3���r~b�}�����D�0���~�����r����|�\Sh�[�>w1�a�`?$<��=Vg�����p���amB�����4f��u��>�����
��h�>d=>�~�	�~�\G���1�AN���ο�X�2Z���>��	7�����g���
�'�9?��=�uM�~�d=q��f�D+n��������̂�3����x}����3-�'�f��-���s�_ы��	���ϳ_~���%�x&������~|B%r#��	��-�`{��2��W8�}E�ޓ+aw:����y	�]���or�>~SX����w�ٽ`��?��=!?��	NqC�o|��N�����U.�	rI��,׻у���Ä�]��_����o,Y���>'�� �?�������a�uvꗭ�
���q~F������o�����|B^�� �*��0�}!o���(���ϒ+`+x��_���e�ZB����E1�ᣳS�l]B�/�>T9�SR�^*��%�5r!�r!̑�aM��~�ы�_�'�����y�����!�ya���:=_�"V����	����Ҙ���/��};�8�����L��,��.ȧ~�~���^x~/�JB�L{�.�\S�O��?���D'���'���z��ԯ�U{sX��+�U.��>���0��_؞���_��I�w�����e���r�т��Y�m���٩�,�?q~�!/����U��������ًk������I^Oc�\qM�����dM��Ŏ�M�˗0�eLǖL���0�����ҏ�������ɛ.9?�[1���ۏp�3�8��<���/[g�W:n�b����:?�2�_I�,�Un��B^嶷���;�Arl�k	�>��g��Og�~ٺ-�>G{Kx�U����e��B��v�U�����R�������pD�bc^1�aLb	[�������zz��E�\e~^�Մ���~6���1NԸ������th�
��U��};��"����_���5��G�U��Z�'�������w��w��m�`_�K��4��8Q�k������u��^��t^w~^�p�B޵b^�g1�E!��k�ƾ�/��W�C-��7f�w��;���z��O��O����`�!���.�p*��+�]�g������]1�ڳػ�y7\.�_�W�r���~����Oԟ����S�f���F쯸�Q�`����'�ܟބ��0�՛ͯ��>�9��[p��������=�G]lw,�Nχ���]��;�w�t[�綫�֔W�n݊��V�o�)�r5�,B>p{���a��/.�݁��X����׵����Y�?�O�Z݉��ѿ������{䰵wz>�d~�.lo�a�.������N����ɣS�;����b�\\�h�ߕ��w����u���n��Ǽc�wzޱd~˷Z�@{��f}�Z����ʕp��j��5�U�[����������a����]K�3��>�X�!n�_x���U-?���|S��u���}-�#�U?n�`v�|Ø�w�Oa[he�{��[O��Y�X������	���۽Aƃ�����<O�4��Z>�9�/Y�Ʈ�W�`M����=��E�C9>���t��n��������!_�������W����������#�q�[������]��<��Vg��7���9cM�8=_�	�.��觏C4�s~� �0�/�/i�*�\S^Or�xV��<����(����=��hL?Z���/6��?�~1������)F���`	p������U�?��L����gռ����<�i>�媌���������w�����8Z��y�9���֟^�y}|�Ƴj���<�!m�4�ơr	Ƒz�z���|t���8lb�E��C�_w�AΔ�~�\J���S�~�y5����s���~K8�Τ����V����Y��σ�W��AF�_��/�|�r��q���9^h�_w^���eֻ.��~�QL�Px>K�����E�ɗw�^���K֓ﾔ����?�y��������V��|�\7�ٵ��P_��םW���+9O�R���z^�}u�W��B��ˍ��Ϋq�q�UԿJ���*c�z�0���q�rLڸr��ZZ���jn�c�����9N�����ټ�߼b=y�c�q7^��|�u��m��~~~C�y=T�~�$</~y���ug�ﾑ�Go���[ד��~�5��)/�:B~�����y�jy3y��N��������\h���]�>���p�rԙp�g�~���l��zx1T���RYnyR�Nt�[[^��4�\��߉��-ߢ�����{�6��<�m�y(,������������ݷ]��%!_Z��#�m��w��p��$�0����ɺ����u�;��~�;e�[T����Wǯ��w�ַ����O�X�W����rnƫƹ���U�?Wדw3/f�ƺ6/`���˴a�}����ϫ��7��V�{�û֓��]�he���]�~"�;���\�߉痴�q�yq�X1a�bJ��o~~��
X�]�{����:�0Nӻ.`��?��7�׮��^��+,���2n� �f1w�O��dޓ�v�iۥ���������i�]�[�u��C��ƛ�;�F���ml;N��v��st���3����;��������w�[�!������C���_�7�M�c����y�[4��7_���7	����.Ͽ�c �X0_�7_���B���}�~�Y����w��o�쯎��ߏ���\H���-�|�������3�9�������5�����v����z��_T/���?��m���X����瓼_9���)Zk���	��f��Pu�;����e~~,�;�[�|��[�-�W쿫����m�i���~H��&���x�����5��h"���|kخ	ǳ�뮸<�~��]�K�o
y5�̑;\2�_����C�|I�H���C-��uG8�i�`������s���;e���z�Q�c����"�/���qLi����Mla�P�y�Ǹ.���lt�7ן��p�m~_���%���K��>���w!�[>1?��mK��!WP��� u�r��!�_h-��\w?��.y!׻?)<�ݷd�Aa���}~���q��O�?>��I��E�2N3��`���sa���j//����K������ª?���p���7.��1?�����B�w��K���q���q��\��%�|�ګK�_�}��W���gv^����ϑ1�Ilb�S��/ʫ��ZN��l
�g�=��^!j�-�m�f~?�������K�e���������x}�����o�s}�����֓�}n~~�|P��h������L�/0�h��~���|�\����o�'/���΂�
ֱ!��z:p}�������Q�a
�X����U�����-O꿎��Ж7A3˱�&ڗ\�ޟ�o��-O�>��g���桵�<8�\�L̓�/�ߕ���o����P���r�����Y�_:��r�_Xn9뮯}��à�;�_ы��^��v��C���6:p����յ�6���q��]v\����O�Oh�_����η�c��g7��)ƙ���Ua}������S��m�#v���:,�c<��㳶`�J�f|���������.���e�C:��q��C��o�'���q=v�e�;�|��,����w��}+懬�{l�io=y�9��.��V�؏�ϯ��V�7��N��?�a^1oa���6::����s�G�GX�8X���z�=�u��l,��"gX�3nG'��_O^m��]�ڼ�uN�����Nm��~CB>�y4�U<��9n��M<b;�����㢌����b���������̷�o��ƿ͸����[�?���i�O<�e=v1��H������ۯ0�g+��/Ϳ���X/������[T��������Y���T?���y%��=,X��+���\w������V�]���ԟx�*�ϊ��u,8��?�`]u>�1�����1Vx�s(��)}��>L����[���}�t�9[�d���������d���e���0���<=�g<�_-XS^��F�Y��q���V?��Ol_�������G�w�9х{�x���{�o?��#5ar���������Ώ�a�?ZO>#�;+�B~F���*�����i��?�����}���Z�����Ѝ}���O8_�������_\��;?�7��K��"Wĭ���.z!�o���_��\������؏1A]�B�����|�������u��s�/���υ�˴G��?,�����ϯ>�n���_�?>��I��E�5�t�8�?�����"�/T{}��gڼ�q:�?oV}S8_����{�~��G�?��\X��|���?[��������ʅ\�����d���j�/8OX�� �/z��",`	'�������b�~����X��p�=�磸��c���h�g*���mt�����8���������_u�'~>F�>F0�i�,�`�B^��0.�Wi����O��0�a�������y~��?q��­��^x�A{s��������lP׾��C��h�.�����?ȥה���,�����ј˭)W�%�m�rh�C�o3m����~�2��Z���-�^}�1�N���ʸ��8������,쿪}k��s�W��q�-S�<�.���������?�8������|�\f�|�ܶ���)?&��d�51�_m{Hǥg��P�>��z�)L������y8rY< W��/����1���߄�Kc��SB.�b>��|寧o�3͟��XE��wgKo��Np�֓��/5��6~�l��U?9����6&0��