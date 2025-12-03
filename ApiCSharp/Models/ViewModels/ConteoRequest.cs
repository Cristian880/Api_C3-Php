using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace ApiCSharp.Models.ViewModels
{
    public class ConteoRequest
    {
        public string Descripcion { get; set; }
        public int Cantidad { get; set; }
    }
    public class ConteoRequestEdit
    {
        public int IDINV { get; set; }
        public string Descripcion { get; set; }
        public int Cantidad { get; set; }
    }
}