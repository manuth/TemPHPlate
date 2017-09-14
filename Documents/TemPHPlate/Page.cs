using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public class Page : WebContent, IRenderer
    {
        public MenuBar MenuBar { get => throw new NotImplementedException(); set => throw new NotImplementedException(); }

        public bool SupportsMenuBar { get => throw new NotImplementedException(); set => throw new NotImplementedException(); }

        public Renderer Renderer
        {
            get => default(int);
            set
            {
            }
        }

        public string Render(IRenderable item)
        {
            throw new NotImplementedException();
        }

        public override string Draw()
        {
            throw new NotImplementedException();
        }

        protected override string DrawInternal()
        {
            throw new NotImplementedException();
        }
    }
}