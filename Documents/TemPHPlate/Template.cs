using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public class Template : WebContent
    {
        public Page Page
        {
            get => default(Page);
            set
            {
            }
        }

        public WebContent Content
        {
            get => default(WebContent);
            set
            {
            }
        }
    }
}