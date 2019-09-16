this["wp"] = this["wp"] || {}; this["wp"]["blockSerializationDefaultParser"] =
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 258);
/******/ })
/************************************************************************/
/******/ ({

/***/ 258:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parse", function() { return parse; });
/* harmony import */ var _babel_runtime_helpers_esm_slicedToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(28);

var document;
var offset;
var output;
var stack;
/**
 * Matches block comment delimiters
 *
 * While most of this pattern is straightforward the attribute parsing
 * incorporates a tricks to make sure we don't choke on specific input
 *
 *  - since JavaScript has no possessive quantifier or atomic grouping
 *    we are emulating it with a trick
 *
 *    we want a possessive quantifier or atomic group to prevent backtracking
 *    on the `}`s should we fail to match the remainder of the pattern
 *
 *    we can emulate this with a positive lookahead and back reference
 *    (a++)*c === ((?=(a+))\1)*c
 *
 *    let's examine an example:
 *      - /(a+)*c/.test('aaaaaaaaaaaaad') fails after over 49,000 steps
 *      - /(a++)*c/.test('aaaaaaaaaaaaad') fails after 85 steps
 *      - /(?>a+)*c/.test('aaaaaaaaaaaaad') fails after 126 steps
 *
 *    this is because the possessive `++` and the atomic group `(?>)`
 *    tell the engine that all those `a`s belong together as a single group
 *    and so it won't split it up when stepping backwards to try and match
 *
 *    if we use /((?=(a+))\1)*c/ then we get the same behavior as the atomic group
 *    or possessive and prevent the backtracking because the `a+` is matched but
 *    not captured. thus, we find the long string of `a`s and remember it, then
 *    reference it as a whole unit inside our pattern
 *
 *    @cite http://instanceof.me/post/52245507631/regex-emulate-atomic-grouping-with-lookahead
 *    @cite http://blog.stevenlevithan.com/archives/mimic-atomic-groups
 *    @cite https://javascript.info/regexp-infinite-backtracking-problem
 *
 *    once browsers reliably support atomic grouping or possessive
 *    quantifiers natively we should remove this trick and simplify
 *
 * @type RegExp
 *
 * @since 3.8.0
 * @since 4.6.1 added optimization to prevent backtracking on attribute parsing
 */

var tokenizer = /<!--\s+(\/)?wp:([a-z][a-z0-9_-]*\/)?([a-z][a-z0-9_-]*)\s+({(?:(?=([^}]+|}+(?=})|(?!}\s+\/?-->)[^])*)\5|[^]*?)}\s+)?(\/)?-->/g;

function Block(blockName, attrs, innerBlocks, innerHTML, innerContent) {
  return {
    blockName: blockName,
    attrs: attrs,
    innerBlocks: innerBlocks,
    innerHTML: innerHTML,
    innerContent: innerContent
  };
}

function Freeform(innerHTML) {
  return Block(null, {}, [], innerHTML, [innerHTML]);
}

function Frame(block, tokenStart, tokenLength, prevOffset, leadingHtmlStart) {
  return {
    block: block,
    tokenStart: tokenStart,
    tokenLength: tokenLength,
    prevOffset: prevOffset || tokenStart + tokenLength,
    leadingHtmlStart: leadingHtmlStart
  };
}
/**
 * Parser function, that converts input HTML into a block based structure.
 *
 * @param {string} doc The HTML document to parse.
 *
 * @example
 * Input post:
 * ```html
 * <!-- wp:columns {"columns":3} -->
 * <div class="wp-block-columns has-3-columns"><!-- wp:column -->
 * <div class="wp-block-column"><!-- wp:paragraph -->
 * <p>Left</p>
 * <!-- /wp:paragraph --></div>
 * <!-- /wp:column -->
 *
 * <!-- wp:column -->
 * <div class="wp-block-column"><!-- wp:paragraph -->
 * <p><strong>Middle</strong></p>
 * <!-- /wp:paragraph --></div>
 * <!-- /wp:column -->
 *
 * <!-- wp:column -->
 * <div class="wp-block-column"></div>
 * <!-- /wp:column --></div>
 * <!-- /wp:columns -->
 * ```
 *
 * Parsing code:
 * ```js
 * import { parse } from '@wordpress/block-serialization-default-parser';
 *
 * parse( post ) === [
 *     {
 *         blockName: "core/columns",
 *         attrs: {
 *             columns: 3
 *         },
 *         innerBlocks: [
 *             {
 *                 blockName: "core/column",
 *                 attrs: null,
 *                 innerBlocks: [
 *                     {
 *                         blockName: "core/paragraph",
 *                         attrs: null,
 *                         innerBlocks: [],
 *                         innerHTML: "\n<p>Left</p>\n"
 *                     }
 *                 ],
 *                 innerHTML: '\n<div class="wp-block-column"></div>\n'
 *             },
 *             {
 *                 blockName: "core/column",
 *                 attrs: null,
 *                 innerBlocks: [
 *                     {
 *                         blockName: "core/paragraph",
 *                         attrs: null,
 *                         innerBlocks: [],
 *                         innerHTML: "\n<p><strong>Middle</strong></p>\n"
 *                     }
 *                 ],
 *                 innerHTML: '\n<div class="wp-block-column"></div>\n'
 *             },
 *             {
 *                 blockName: "core/column",
 *                 attrs: null,
 *                 innerBlocks: [],
 *                 innerHTML: '\n<div class="wp-block-column"></div>\n'
 *             }
 *         ],
 *         innerHTML: '\n<div class="wp-block-columns has-3-columns">\n\n\n\n</div>\n'
 *     }
 * ];
 * ```
 * @return {Array} A block-based representation of the input HTML.
 */


var parse = function parse(doc) {
  document = doc;
  offset = 0;
  output = [];
  stack = [];
  tokenizer.lastIndex = 0;

  do {// twiddle our thumbs
  } while (proceed());

  return output;
};

function proceed() {
  var next = nextToken();

  var _next = Object(_babel_runtime_helpers_esm_slicedToArray__WEBPACK_IMPORTED_MODULE_0__[/* default */ "a"])(next, 5),
      tokenType = _next[0],
      blockName = _next[1],
      attrs = _next[2],
      startOffset = _next[3],
      tokenLength = _next[4];

  var stackDepth = stack.length; // we may have some HTML soup before the next block

  var leadingHtmlStart = startOffset > offset ? offset : null;

  switch (tokenType) {
    case 'no-more-tokens':
      // if not in a block then flush output
      if (0 === stackDepth) {
        addFreeform();
        return false;
      } // Otherwise we have a problem
      // This is an error
      // we have options
      //  - treat it all as freeform text
      //  - assume an implicit closer (easiest when not nesting)
      // for the easy case we'll assume an implicit closer


      if (1 === stackDepth) {
        addBlockFromStack();
        return false;
      } // for the nested case where it's more difficult we'll
      // have to assume that multiple closers are missing
      // and so we'll collapse the whole stack piecewise


      while (0 < stack.length) {
        addBlockFromStack();
      }

      return false;

    case 'void-block':
      // easy case is if we stumbled upon a void block
      // in the top-level of the document
      if (0 === stackDepth) {
        if (null !== leadingHtmlStart) {
          output.push(Freeform(document.substr(leadingHtmlStart, startOffset - leadingHtmlStart)));
        }

        output.push(Block(blockName, attrs, [], '', []));
        offset = startOffset + tokenLength;
        return true;
      } // otherwise we found an inner block


      addInnerBlock(Block(blockName, attrs, [], '', []), startOffset, tokenLength);
      offset = startOffset + tokenLength;
      return true;

    case 'block-opener':
      // track all newly-opened blocks on the stack
      stack.push(Frame(Block(blockName, attrs, [], '', []), startOffset, tokenLength, startOffset + tokenLength, leadingHtmlStart));
      offset = startOffset + tokenLength;
      return true;

    case 'block-closer':
      // if we're missing an opener we're in trouble
      // This is an error
      if (0 === stackDepth) {
        // we have options
        //  - assume an implicit opener
        //  - assume _this_ is the opener
        //  - give up and close out the document
        addFreeform();
        return false;
      } // if we're not nesting then this is easy - close the block


      if (1 === stackDepth) {
        addBlockFromStack(startOffset);
        offset = startOffset + tokenLength;
        return true;
      } // otherwise we're nested and we have to close out the current
      // block and add it as a innerBlock to the parent


      var stackTop = stack.pop();
      var html = document.substr(stackTop.prevOffset, startOffset - stackTop.prevOffset);
      stackTop.block.innerHTML += html;
      stackTop.block.innerContent.push(html);
      stackTop.prevOffset = startOffset + tokenLength;
      addInnerBlocLr��!�D�*M�RB�jI�EEE@Z 4�b�?�}l��e�}ϙsO.`��o�<O���9s��Sc��oc7�k*k�-�$b̷��	��������X��ɷ]`]��L~��ҟ5���+��=����w^h]��1�E��~��}խ%Ac[�Z��[�?���eb�����mb{��}�#�{����l;����cǾ)h�cǾ)�cǾ)��cǾ)ؔcǾ)8�cǾ)��k�>�E�,��?�~Mg�W�9���؟4i,��tD�X���~ǟ(�s_��vS��Z����[,��o��:�M~�b�&q���������{g��'�$p���:��q���_ǿ�S���F��!���Y�(k�Y�
./��?QK��O�cK��OA�R�S����Z��]��Ӓ?���Z���*���f��b�~��Zn�~ğ(��ru�ż��c��_�ձo�_���7�:y:�M>5OǾ�/�ӱo���t�|�%:���W݊���.�W�����Ĺ "R�To�<��RR�����k�@�}���T�����~��-Z}A{c^��>�ՙ���,���V��j����Jw-�(���})u��f�0�~�N8
k�%=�?*��5�mOPt�A˷�<_����ϗg����Ǵ����s�t�C�����9�?:O۟.Ϟ��[�ߖg���i��zy��2]��Ep9��G��eGy��\���+�g�"r�j"��;�jSD���n��[��L'�O��f ���J�l^?�����8��u]�"H3	l^;Z��W�R�y��k6�}�v�*��l^O�ͫ{�ye���W9�f�~�n^�؛�+��ݼʱ7��{'��U��ټ����U��ټ枲�W9�f���ݼʱ��W��j�܁���;s���]�+�1�<�L�(؊+�|�y�-:F���_}����M��~�����q<^Tˑ��ѣ��ѿ��L�>#���6��q>.ή;F�7��C��������1ʂ��b7�ˊ7�~�^�����`�(��v������e��>n�Qi"
���D��7��W�+�.�cf����4�.-��e��e/*"˪���}k,�E�>4�A��,��=я���e�g�#��YV���D��&ٞ�\eYU���z�Uu���Mn]u�U�m�Jtyvq��fN��
+`�'�� zQ6��b��j>-��-P��ڪ��®�;z��Iuw�����(���;j��Z���)��~�q
�y��k8֨�
����:�*[E��BD�W��Pr�=OQ��P�l��>�Y�QX� [VMt�X��� ��Da�5:/2�PM���J��KB�aŃ�����Vm����T��'�Fm���ڻ�-���1�����Z��*�W��v��j�U������$N��%�^�W=�ȖFW[m��9��sc�����~k�ôZ\�ʧ���t����㸋,]+KwدZd�,��(���Z�OK��c+����o+�.��ƀE�:��gq�XL��ʇ��|{��)=V�I���:4��\C
G�ơ�cY{��qZ�\��"��e�
���+ӂ;N/���"S��/a�R���,��x�5<���ioM���ELU����T�9n�j�^�q���������6����:evE�@��ڲ��z�X/�<�Vd "�(�Wԥ�v#�W��x�]��Rd�,�,7Ku}�X���� a���n��.UkS�w�θ7%�D��7���]*r�&�A��8
/�/ju�lK}���Q����XB��R�e���V�g��u3���;�Rǻ��L��=>��]��:�%�L�|��%r>����KH�CHE��2AR�&�:I�}��G, <�WBZC°v��� O'N$]�(6���%
���o"l�C�XJ�t���{����u	�5'�ޓ�-��}a�"�E�7�v�'��=a�}� ����$�;���%�{k���@8���
��$�!y�P҅p�?��hB�T��7	��N�@8Sy1��	�#|�H8ۇpn��B�Y�6����oz�R?!����<����3�f�',�IX:��K�Ļ�>G.v*��lB�2B�M����� ���0�a�;0���W[��
�Ƨ	ۧvg���Ax�a�و��	g��y����4Mƻr�&�$LJ%L�Hxaa�Z´���f�Dx1,�Ru¬F�̎���$�2�0�%��U�y;	YG�//a]W%,~��O�DX:��<��ba�aB�g��_	������0��^*a_a�t\���K	��{��	�!�N(@86�p|6�t�ć���	��,4���̋�PW
�"dgr�gQ�+w�%�	K��!,�HXy����gAXU�PX�PC(~���=a]7��>�CG6�'l�IؚExm	a[a�V��oTйv��.�����-�3|�
�G�V�
�v��Z�&�iAh�@�M%�Gxl!.��P���3���	�J	C��~KH��6�0�.!�-�כ0r$a�,U�g�ƞ#<w�0���w0�j��&�'L�J�4�0�i	�f�.#L��0���I���2;^�G��,a�˄y����	�?T�5�!֫��8ΰJح�+�?$��^	o�&�����R.����������zѨ��n�@���\/�S%���z�^
�3V�V��5q�)Ec�k~��Зù)N�[�yd��]�������Akw�SL�S�{��W���Akw�.I8�\��wt[:�/8�~�qt؉��Zi��]����(|��v"��r��鮇k�4�{���~���ʵ�;�����t��\������y���I��b�h;���c�[4��� c��u^){���1��8��t��ʵ�{�óʺg:�3�	ǔk�>����e��:��:�a'��b���g�9��ɥ����$��AZ$QL�J��Ǿ�_�������>*q�%���ݢf#�
�V�Ww��g�7��}J�Q� ���t��;�0R1�!����^��n�"a�2��(��3/�R���V�*iۻ]f�Z�H�Y"D�c���i"��J,ˠ��K4$<���sT�m|��>�7i�q!�G����R����\�I�O�����2���(��g�?:F��E��u������'��nT�u��j�V-�%>v"���c8��������nҢG���w�����]��%�_y٤[���ە�w��X�{��,����`5# ��k��8mZ}
�y]`^�*���R��2��d^���X��
��XͥU��X�s�(+���8�G�kBL�FA���J�j�T�ח�0WX	:�G��\��:��e^s�E�i5
V�Xa���G!��#7`u���V�h5�'��OL}�%�wk��Zͼ.������K�oʖUk���B������]Y��i}����pe�i5Vjb k"�]nP0ViVi�z\Y,0���*=�*�V+��'��X��/D�&�h�N��!�,�v���q�Li��n�|t��R�������8��R���RW%w�$c��d,�k���mz\vBF�*��}�͞}�9�<B��O�{��:���uI̧L>ب\&�%�e�Ӏ ���� � I&XR1�24���r5rd	�$cWV9	�+���%U
��%d�\e%���]*�p,�"���q���DTR�=�[ac�GWEV�Jxu�*�l�y��Jf�dOp�JU��Aʤ�[]�����Uж�`�!����B�Po�3��H�u�(�j�ﳅBl[���~U����?�Nh�m��}U�����a�{U^a`7����I�)B`�*�����W����M�qI�sT�a�3J��n�(�EÍ.�E�0�e�h�d��7�D�:p���7�Pt�~��������bG��������B�A�˽{��LZ�2]^�(��PE���Y������|\�����#V<9��Q��EV��e��-�*+?�����E�U���C�X�_��/y,��?�^WlU�ߋoS�������6��ت��ŷ���n���{��Q�sݦ�Oݦ�-�W�$���D�>U�Cc�ͥƂ���m[�ZP	_|�_D1KI���k��
步0]�~�?%��0���}X�#<��ư���po��}���zd������wX���������ɨ�}NћA?s�w����~��w����KY�؆�B���1�u�l�[x7��'���z���ֻW�-AOy�{P�N����3�x�(ݐ�/&	9Z)uj`ŗ��
B��z���&��u^���������M�%�2|E���6-�L����M�[�"�q��.U�����XnT�ygUY9�L��>���Pdb���o��w�E.1��꽤�x:D��ol:D����n����7���l,�A5-��oM�x��5�`�����Dzki��(o}M?\���ս-4ݬ�7��y�lq����q*�-���t�O�o�eP9WxM煈��WP���*�4���="%U1��%{��fIl�gRݕa2({[�����$)l�$�A� �"X�b ����c�V��<{T�<�s57u5��<!��HD�+��]Pʥ&
<)M¾�)� �����r)C_�܈j*�P���G���0�zL�+��o�4������$���$(>W}m���+��y�3��C��0_��^��ő��7ػ�X�U�@�PE��2$XY,��Cb �W�ͧ�Z�nC�$f�h���2p���e`�K_X�J6Ro����-K&#�)�=��H�rxs��B��U��	�hȰ��dVb�\�&�XuЇ�@"�,-�^�U����j��ə�%
RH$X��?y��J���p$�^u-1l�"+���Ax��h��aG
�++�C��J֠�%�`G�.o*XRH$X��,�f����;R(�Cb ��<�*��mr�0��5�Jh%�~�G�%�w>�_�/���ּubcH��sPҭެ�����`IA&�(�l (���(O�8^���w�>(&<r_h�J,�`讒1���@Q�Db92P��]U�H$r#��0%��[O���<
�
$s��g��2�nS��!1�H�>��Ia���6(YH$f��&��2�f����Hd����N�|H%��d~�`F�[�~����N��L}���<��'�d�N�[%~��X��h;W|9:���17UX��A�fy~ V�\Űq.��&1 �x0C%U1_���
E0�ʑ�*���A6	,:%�ޠxSA�0�l�C��;��w�Q�6c�u>g��l�8�T��R��f|�3�sM�i��R��U�@�g mK