function selectCode(a)
{
   // Get ID of code block
   var e = a.parentNode.parentNode.getElementsByTagName('CODE')[0];

   // Not IE
   if (window.getSelection)
   {
      var s = window.getSelection();
      // Safari
      if (s.setBaseAndExtent)
      {
         var l = (e.innerText.length > 1) ? e.innerText.length - 1 : 1;
         try {
            s.setBaseAndExtent(e, 0, e, l);
         }
         catch (error) {
            var r = document.createRange();
            r.selectNodeContents(e);
            s.removeAllRanges();
            s.addRange(r);
         }
      }
      // Firefox and Opera
      else
      {
         // workaround for bug # 42885
         if (window.opera && e.innerHTML.substring(e.innerHTML.length - 4) == '<BR>')
         {
            e.innerHTML = e.innerHTML + '&nbsp;';
         }

         var r = document.createRange();
         r.selectNodeContents(e);
         s.removeAllRanges();
         s.addRange(r);
      }
   }
   // Some older browsers
   else if (document.getSelection)
   {
      var s = document.getSelection();
      var r = document.createRange();
      r.selectNodeContents(e);
      s.removeAllRanges();
      s.addRange(r);
   }
   // IE
   else if (document.selection)
   {
      var r = document.body.createTextRange();
      r.moveToElementText(e);
      r.select();
   }
}