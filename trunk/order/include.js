function adminToBilling( form )
{
  if( form.billingcopy.checked )
    {
      form.bbusinessname.value = form.abusinessname.value;
      form.bcontactname.value = form.acontactname.value;
      form.bcontactemail.value = form.acontactemail.value;
      form.baddress1.value = form.aaddress1.value;
      form.baddress2.value = form.aaddress2.value;
      form.baddress3.value = form.aaddress3.value;
      form.bcountry.value = form.acountry.value;
      form.bcity.value = form.acity.value;
      form.bstate.value = form.astate.value;
      form.bpostalcode.value = form.apostalcode.value;
      form.bphone_cc.value = form.aphone_cc.value;
      form.bphone_area.value = form.aphone_area.value;
      form.bphone.value = form.aphone.value;
      form.bfax_cc.value = form.afax_cc.value;
      form.bfax_area.value = form.afax_area.value;
      form.bfax.value = form.afax.value;
    }
  else
    {
      form.bbusinessname.value = "";
      form.bcontactname.value = "";
      form.bcontactemail.value = "";
      form.baddress1.value = "";
      form.baddress2.value = "";
      form.baddress3.value = "";
      form.bcountry.value = "";
      form.bcity.value = "";
      form.bstate.value = "";
      form.bpostalcode.value = "";
      form.bphone_cc.value = "";
      form.bphone_area.value = "";
      form.bphone.value = "";
      form.bfax_cc.value = "";
      form.bfax_area.value = "";
      form.bfax.value = "";
    }
}

function billingToTech( form )
{
  if( form.techcopy.checked )
    {
      form.tbusinessname.value = form.bbusinessname.value;
      form.tcontactname.value = form.bcontactname.value;
      form.tcontactemail.value = form.bcontactemail.value;
      form.taddress1.value = form.baddress1.value;
      form.taddress2.value = form.baddress2.value;
      form.taddress3.value = form.baddress3.value;
      form.tcountry.value = form.bcountry.value;
      form.tcity.value = form.bcity.value;
      form.tstate.value = form.bstate.value;
      form.tpostalcode.value = form.bpostalcode.value;
      form.tphone_cc.value = form.bphone_cc.value;
      form.tphone_area.value = form.bphone_area.value;
      form.tphone.value = form.bphone.value;
      form.tfax_cc.value = form.bfax_cc.value;
      form.tfax_area.value = form.bfax_area.value;
      form.tfax.value = form.bfax.value;
    }
  else
    {
      form.tbusinessname.value = "";
      form.tcontactname.value = "";
      form.tcontactemail.value = "";
      form.taddress1.value = "";
      form.taddress2.value = "";
      form.taddress3.value = "";
      form.tcountry.value = "";
      form.tcity.value = "";
      form.tstate.value = "";
      form.tpostalcode.value = "";
      form.tphone_cc.value = "";
      form.tphone_area.value = "";
      form.tphone.value = "";
      form.tfax_cc.value = "";
      form.tfax_area.value = "";
      form.tfax.value = "";
    }
}

function clearDomainOptions( form )
{
  form.registerdomainname.value = "";
  form.registerdomaintld.value = "";
  form.transferdomainname.value = "";
  form.transferdomaintld.value = "";
  form.existingdomainname.value = "";
}