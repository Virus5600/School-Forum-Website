$((function(){var t=$("[data-paginator-ellipsis]"),n=t.data("paginator-max"),a=t.data("paginator-min");t.data("paginator-url"),t.on("click",(function(t){t.preventDefault(),Swal.fire({title:"Go to Page",input:"number",inputLabel:"Go to a page between 1 and ".concat(n),inputAttributes:{min:a,max:n},showConfirmButton:!0,showCancelButton:!0,confirmButtonText:"Go",cancelButtonText:"Cancel",confirmButtonColor:"var(--bs-it-primary)",cancelButtonColor:"var(--bs-secondary)",inputValidator:function(t){return t?(t=parseInt(t.trim()),isNaN(t)?"You need to write a number!":t<a||t>n?"You need to write a number between 1 and ".concat(n,"!"):void 0):"You need to write something!"}}).then((function(t){t.isConfirmed&&(window.location.href=window.location.href.replace(/page=\d+/,"page=".concat(t.value)))}))}))}));
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiL2pzL3dpZGdldC9wYWdpbmF0b3Itd2lkZ2V0LmpzIiwibWFwcGluZ3MiOiJBQUFBQSxHQUFFLFdBQ0QsSUFBTUMsRUFBV0QsRUFBRSw2QkFDbEJFLEVBQU1ELEVBQVNFLEtBQUssaUJBQ3BCQyxFQUFNSCxFQUFTRSxLQUFLLGlCQUNkRixFQUFTRSxLQUFLLGlCQUVyQkYsRUFBU0ksR0FBRyxTQUFTLFNBQUNDLEdBQ3JCQSxFQUFFQyxpQkFFRkMsS0FBS0MsS0FBSyxDQUNUQyxNQUFPLGFBQ1BDLE1BQU8sU0FDUEMsV0FBWSw4QkFBRkMsT0FBZ0NYLEdBQzFDWSxnQkFBaUIsQ0FDaEJWLElBQUtBLEVBQ0xGLElBQUtBLEdBRU5hLG1CQUFtQixFQUNuQkMsa0JBQWtCLEVBQ2xCQyxrQkFBbUIsS0FDbkJDLGlCQUFrQixTQUNsQkMsbUJBQW9CLHVCQUNwQkMsa0JBQW1CLHNCQUNuQkMsZUFBZ0IsU0FBQ0MsR0FDaEIsT0FBS0EsR0FJTEEsRUFBUUMsU0FBU0QsRUFBTUUsUUFFbkJDLE1BQU1ILEdBQ0YsOEJBR0pBLEVBQVFsQixHQUFPa0IsRUFBUXBCLEVBQ25CLDRDQUFQVyxPQUFtRFgsRUFBRyxVQUR2RCxHQVRRLDhCQVlULElBQ0V3QixNQUFLLFNBQUNDLEdBQ0pBLEVBQU9DLGNBQ1ZDLE9BQU9DLFNBQVNDLEtBQU9GLE9BQU9DLFNBQVNDLEtBQUtDLFFBQVEsV0FBWSxRQUFGbkIsT0FBVWMsRUFBT0wsUUFDakYsR0FDRCxHQUNEIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL3dpZGdldC9wYWdpbmF0b3Itd2lkZ2V0LmpzIl0sInNvdXJjZXNDb250ZW50IjpbIiQoKCkgPT4ge1xuXHRjb25zdCBlbGxpcHNpcyA9ICQoYFtkYXRhLXBhZ2luYXRvci1lbGxpcHNpc11gKSxcblx0XHRtYXggPSBlbGxpcHNpcy5kYXRhKCdwYWdpbmF0b3ItbWF4JyksXG5cdFx0bWluID0gZWxsaXBzaXMuZGF0YSgncGFnaW5hdG9yLW1pbicpLFxuXHRcdHVybCA9IGVsbGlwc2lzLmRhdGEoJ3BhZ2luYXRvci11cmwnKTtcblxuXHRlbGxpcHNpcy5vbignY2xpY2snLCAoZSkgPT4ge1xuXHRcdGUucHJldmVudERlZmF1bHQoKTtcblxuXHRcdFN3YWwuZmlyZSh7XG5cdFx0XHR0aXRsZTogYEdvIHRvIFBhZ2VgLFxuXHRcdFx0aW5wdXQ6IGBudW1iZXJgLFxuXHRcdFx0aW5wdXRMYWJlbDogYEdvIHRvIGEgcGFnZSBiZXR3ZWVuIDEgYW5kICR7bWF4fWAsXG5cdFx0XHRpbnB1dEF0dHJpYnV0ZXM6IHtcblx0XHRcdFx0bWluOiBtaW4sXG5cdFx0XHRcdG1heDogbWF4XG5cdFx0XHR9LFxuXHRcdFx0c2hvd0NvbmZpcm1CdXR0b246IHRydWUsXG5cdFx0XHRzaG93Q2FuY2VsQnV0dG9uOiB0cnVlLFxuXHRcdFx0Y29uZmlybUJ1dHRvblRleHQ6IGBHb2AsXG5cdFx0XHRjYW5jZWxCdXR0b25UZXh0OiBgQ2FuY2VsYCxcblx0XHRcdGNvbmZpcm1CdXR0b25Db2xvcjogYHZhcigtLWJzLWl0LXByaW1hcnkpYCxcblx0XHRcdGNhbmNlbEJ1dHRvbkNvbG9yOiBgdmFyKC0tYnMtc2Vjb25kYXJ5KWAsXG5cdFx0XHRpbnB1dFZhbGlkYXRvcjogKHZhbHVlKSA9PiB7XG5cdFx0XHRcdGlmICghdmFsdWUpIHtcblx0XHRcdFx0XHRyZXR1cm4gYFlvdSBuZWVkIHRvIHdyaXRlIHNvbWV0aGluZyFgXG5cdFx0XHRcdH1cblxuXHRcdFx0XHR2YWx1ZSA9IHBhcnNlSW50KHZhbHVlLnRyaW0oKSk7XG5cblx0XHRcdFx0aWYgKGlzTmFOKHZhbHVlKSkge1xuXHRcdFx0XHRcdHJldHVybiBgWW91IG5lZWQgdG8gd3JpdGUgYSBudW1iZXIhYFxuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWYgKHZhbHVlIDwgbWluIHx8IHZhbHVlID4gbWF4KSB7XG5cdFx0XHRcdFx0cmV0dXJuIGBZb3UgbmVlZCB0byB3cml0ZSBhIG51bWJlciBiZXR3ZWVuIDEgYW5kICR7bWF4fSFgXG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9KS50aGVuKChyZXN1bHQpID0+IHtcblx0XHRcdGlmIChyZXN1bHQuaXNDb25maXJtZWQpXG5cdFx0XHRcdHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gd2luZG93LmxvY2F0aW9uLmhyZWYucmVwbGFjZSgvcGFnZT1cXGQrLywgYHBhZ2U9JHtyZXN1bHQudmFsdWV9YCk7XG5cdFx0fSk7XG5cdH0pO1xufSk7XG4iXSwibmFtZXMiOlsiJCIsImVsbGlwc2lzIiwibWF4IiwiZGF0YSIsIm1pbiIsIm9uIiwiZSIsInByZXZlbnREZWZhdWx0IiwiU3dhbCIsImZpcmUiLCJ0aXRsZSIsImlucHV0IiwiaW5wdXRMYWJlbCIsImNvbmNhdCIsImlucHV0QXR0cmlidXRlcyIsInNob3dDb25maXJtQnV0dG9uIiwic2hvd0NhbmNlbEJ1dHRvbiIsImNvbmZpcm1CdXR0b25UZXh0IiwiY2FuY2VsQnV0dG9uVGV4dCIsImNvbmZpcm1CdXR0b25Db2xvciIsImNhbmNlbEJ1dHRvbkNvbG9yIiwiaW5wdXRWYWxpZGF0b3IiLCJ2YWx1ZSIsInBhcnNlSW50IiwidHJpbSIsImlzTmFOIiwidGhlbiIsInJlc3VsdCIsImlzQ29uZmlybWVkIiwid2luZG93IiwibG9jYXRpb24iLCJocmVmIiwicmVwbGFjZSJdLCJzb3VyY2VSb290IjoiIn0=